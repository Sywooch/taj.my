<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\ContactForm;
use app\models\Block;
use app\models\Menu;
use app\models\EntryForm;
use app\models\Category;

class AdministratorController extends Controller
{
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
		//$this->view->theme->pathMap =['@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app',]; 
		
		
		$this->layout = 'admin';
		 
        $menu = $this->getMenu();

        $data['blocks'] = $this->getBlocks(['homepage','all']);

		$rev = new ReviewsController();
        $data['reviews'] = $rev->getReview($limit,$page);
        $data['pagination'] = [
            'count' => $rev->getReviewCount(),
            'page'  => $page,
            'limit' => $limit
        ];
        \Yii::$app->view->title = 'Tajrobti';
        return $this->render('index', compact(['menu', 'data','blocks']));
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
        $menu = ['header'=>[], 'footer'=>[]];
        $menu_all = Menu::find(['name','link'])->orderBy(['sort'=>SORT_ASC])->where(['lang'=> Yii::$app->language, 'position'=>['header','footer'] ])->all();
        foreach($menu_all as $m) {
            $menu[$m->position][] = $m;
        }

        return $menu;
    }

    public function getBlocks($page = 'all') {
        return Block::find(['title','image','content'])->orderBy(['sort'=>SORT_ASC])->where(['lang'=> Yii::$app->language, 'page_type'=>$page ])->all();
    }

    public function getParent($parent, $storage=[]) {
        $criteria = Category::find();
        $criteria->where('id=:parent_id',true);
        $criteria->params=array(':parent_id'=>$parent);
        $model =  $criteria->all();
        foreach ($model as $key) {
            $storage[] = [
                'id'    => $key->id,
                'name'  => $key->name,
                'link'  => $key->link,
            ];
            if($key->parent_id!=0) {
                $storage = self::getParent($key->parent_id, $storage);
            }
        }
        return $storage;
    }
}
