<?php
/**
 * Created by PhpStorm.
 * User: villa
 * Date: 28.11.2018
 * Time: 0:09
 */

namespace app\controllers;


use app\models\Information;
use yii\helpers\Url;

class InformationController extends SiteController
{
    public function actionContent($link) {

        $menu = $this->getMenu();
        $data['blocks'] = $this->getBlocks(['productMain','all']);

        $data['content'] = Information::find()->alias('i')->joinWith('content')->where(['i.link'=>$link])->one();

        if($data['content']) {
            \Yii::$app->view->title = $data['content']->content->title;
			if($link=='support')
				return $this->render('support', compact(['menu', 'data']));
			else 
				return $this->render('index', compact(['menu', 'data']));
        } else {
            $this->redirect(Url::to(['/']), 302);
        }
    }
}