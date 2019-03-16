<?php
/**
 * Created by PhpStorm.
 * User: villa
 * Date: 28.11.2018
 * Time: 0:09
 */

namespace app\controllers;

use app\models\Product;
use Yii;

class CompareController extends SiteController
{
    public function actionIndex() {

        $menu = $this->getMenu();
        $data['blocks'] = $this->getBlocks(['productMain','all']);
        
        \Yii::$app->view->title = \Yii::t('main', 'PrsCompare');
		
        $session = Yii::$app->session;
        if(isset($session['compare'])&&count($session['compare'])>0) {
            $products = Product::find()
                    ->alias('product')
                    ->joinWith('category');
                    $c=[];
                    foreach($session['compare'] as $s) {
                        $c[] = $s;
                    }
            $products->where(['product.id' => $c]);
            
            $data['products'] = $products->all();
        } else {
            $data['products'] = [];
        }
        return $this->render('index', compact(['menu', 'data']));
    }
}