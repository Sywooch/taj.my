<?php
namespace app\controllers;

use function var_export;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\ContactForm;
use app\models\Block;
use app\models\Menu;
use app\models\EntryForm;
use app\models\Category;

class SiteController extends Controller
{
    public $menu;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($limit = 5,$page = 0)
    {
        $this->view->params['menu'] = $this->getMenu();

        $data['blocks'] = $this->getBlocks(['homepage','all']);
		
		$data['userRole']	= $this->getCheckActiveRole();
		
		$rev = new ReviewsController();
        $data['reviews'] = $rev->getReview($limit,$page);
        $data['pagination'] = [
            'count' => $rev->getReviewCount(),
            'page'  => $page,
            'limit' => $limit,
        ];
        \Yii::$app->view->title = \Yii::t('main', 'Tajrobtak');
        return $this->render('index', compact([ 'data','blocks']));
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionEntry()
    {
        $model = new EntryForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // valid data received in $model

            // do something meaningful here about $model ...

            return $this->render('entry-confirm', ['model' => $model]);
        } else {
            // either the page is initially displayed or there is some validation error
            return $this->render('entry', ['model' => $model]);
        }
    }

    public function getMenu()
    {
        $menu = ['header'=>[], 'footer'=>[], 'title'=>[]];
        //необходимо включить кеш ->cache(72000)->all()
        $menu_all = Menu::find(['name','link'])->orderBy(['sort'=>SORT_ASC])->where(['lang'=> Yii::$app->language, 'position'=>['header','footer', 'title'] ])->all();
        foreach($menu_all as $m) {
            $menu[$m->position][] = $m;
        }

        return $menu;
    }

    public function getBlocks($page = 'all') {
        return Block::find(['title','image','content'])->orderBy(['sort'=>SORT_ASC])->where(['lang'=> Yii::$app->language, 'page_type'=>$page ])->cache(72000)->all();
    }

    public function getParent($parent, $storage=[]) {
		if($parent>0) {
			$criteria = Category::find();
			$criteria->where('id=:parent_id',true);
			$criteria->params=array(':parent_id'=>$parent);
			$model =  $criteria->all();
			if($model&&count($storage)<10)  // 10 - max stock size of category
			foreach ($model as $key) {
				$storage[] = [
					'id'    => $key->id,
					'name'  => $key->name,
					'link'  => $key->link,
				];
				if($key->parent_id>0) {
					$storage = self::getParent($key->parent_id, $storage);
				}
			}
		}
        return $storage;
    }
	
	public function getCheckActiveRole() {
		$roles = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->id);
		
		foreach($roles as $role) {
			if($role->name=='admin'||$role->name=='moderator') {
				return true;
			}
		}
		return false;
	}
}
