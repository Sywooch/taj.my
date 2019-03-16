<?php
/**
 * Created by PhpStorm.
 * User: villa
 * Date: 17.10.2018
 * Time: 23:02
 */

namespace app\controllers;

use app\models\BillingProcessForm;
use app\models\BillingStatusName;
use app\models\Block;
use app\models\Profile;
use app\models\Review;
use app\models\Billing;
use app\models\BillingProcess;
use app\models\Dialog;
use app\models\DialogMessage;
use app\models\DialogForm;
use app\models\Menu;
use app\models\UserInvite;
use dektrium\user\models\User;
use Symfony\Component\Console\Tests\Fixtures\DescriptorCommand1;
use Yii;
use yii\helpers\Url;

class UserDataController extends SiteController
{
    public function UserdataIndex($id = 0) {
        echo 'USER PAGE #'.$id;
        return [];
    }

    public function actionUserReviews($page = 0, $limit = 5) {
        \Yii::$app->view->title = \Yii::t('main', 'Your Reviews');
        if(Yii::$app->user->identity) {
            $menu = $this->getMenu();
            $user_id = Yii::$app->user->identity->id;

            $data['reviews'] = $this->getReviewByUser($user_id, $limit, $page);

            $data['pagination'] = [
                'path' => 'user/reviews',
                'count' => $this->getReviewCountByUser($user_id),
                'page' => $page,
                'limit' => $limit
            ];

            return $this->render('user-review', compact(['menu', 'data']));
        } else {
            $this->redirect(Url::to(['user/login']),302);
            return false;
        }
    }

    public function actionUserDialog() {
        \Yii::$app->view->title = \Yii::t('main', 'Your Dialogs');
        if(Yii::$app->user->identity) {
            $menu = $this->getMenu();
            $user_id = Yii::$app->user->identity->id;

            $data['dialogs'] = Dialog::find()
                ->where(['user_from'=>$user_id])
                ->orWhere(['user_to'=>$user_id])
                ->joinWith('dialogMessage')
                ->joinWith('profileTo')
                ->joinWith('profileFrom')
                ->limit(100)
                ->orderBy('update_date')
                ->all();

            return $this->render('user-dialog', compact(['menu', 'data']));
        } else {
            $this->redirect(Url::to(['user/login']),302);
            return false;
        }
    }
	
	

    public function actionUserDialogShow($dialog_id) {
        if(Yii::$app->user->identity) {
            $menu = $this->getMenu();
            $user_id = Yii::$app->user->identity->id;

            $data['dialog'] = Dialog::find()
				->where(['dialog_id'=>$dialog_id])
                ->andWhere(['or',['user_from'=>$user_id],['user_to'=>$user_id]])
                ->joinWith('dialogMessage')
                ->joinWith('profileTo')
                ->joinWith('profileFrom')
                ->orderBy('update_date')
                ->one();
			if($data['dialog']) {
			    $data['form'] = new DialogForm;
				\Yii::$app->view->title = \Yii::t('main', 'Dialog: ' . $data['dialog']['title']);
				return $this->render('user-dialog-show', compact(['menu', 'data']));
			} else {
				$this->redirect(Url::to(['user/dialog']),302);
			}
        } else {
            $this->redirect(Url::to(['user/login']),302);
            return false;
        }
    }

    public function actionUserShow($user_id = 0, $page = 0, $limit = 5) {
        \Yii::$app->view->title = \Yii::t('main', 'Your Reviews');
        if(Yii::$app->user->identity) {

            $menu = $this->getMenu();

            if($data['user'] = Profile::find()->where(['user_id'=>$user_id])->one()) {
                $data['reviews'] = $this->getReviewByUser($user_id, $limit, $page);

                $data['pagination'] = [
                    'path' => 'user/' . $user_id,
                    'count' => $this->getReviewCountByUser($user_id),
                    'page' => $page,
                    'limit' => $limit
                ];

                return $this->render('user-show', compact(['menu', 'data']));
            } else {
                $this->redirect(Url::to(['/']),302);
            }
        } else {
            $this->redirect(Url::to(['user/login']),302);
            return false;
        }
    }

    public function actionUserBilling($page = 0, $limit = 5) {
        \Yii::$app->view->title = \Yii::t('main', 'Your Billing');
        if(Yii::$app->user->identity) {
            $menu = $this->getMenu();
            $user_id = Yii::$app->user->identity->id;
			
            $data['billing'] = Billing::find()->where(['user_id'=>$user_id])->one();
			
			$data['user'] = User::find()->where(['id'=>$user_id])->one();
			
			$data['friends'] = $f_id = [];
            $friends = UserInvite::find()->where(['user_id_invited'=>$user_id])->all();
			foreach($friends as $f) {
				$f_id[] = $f->user_id;
			}
			$data['friends'] = User::findAll(['id' => $f_id]);
			
            $data['transactions'] = BillingProcess::find()
                ->alias('process')
                ->joinWith('statusName')
                ->where(['process.user_id'=>$user_id])
                ->orderBy('process.create_date DESC')->all();
            $data['withdrawModel'] = new BillingProcessForm();

            return $this->render('user-billing', compact(['menu', 'data']));
        } else {
            $this->redirect(Url::to(['user/login']),302);
            return false;
        }
    }



    public function getReviewByUser($user_id,$limit=5,$page=0) {
        $r = Review::find()
            ->alias('review')
            ->joinWith('product')
            ->joinWith('reviewComment')
            ->joinWith('reviewContentFirst')
            ->joinWith('author')
            ->groupBy('review.id')
            ->orderBy(['review.create_date'=> SORT_DESC])
            ->where(['review.user_id'=>$user_id])
            ->limit($limit)
            ->offset($page*$limit)
            ->all();
        return $r;
    }

    public function getReviewCountByUser($user_id)
    {
        return Review::find()
            ->alias('review')
            ->joinWith('product')
            ->groupBy('review.id')
            ->where(['review.user_id'=>$user_id])
            ->count();
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

}