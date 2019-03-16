<?php
/**
 * Created by PhpStorm.
 * User: villa
 * Date: 07.12.2018
 * Time: 17:27
 */

namespace app\controllers;

use app\models\Billing;
use app\models\BillingProcess;
use app\models\BillingProcessForm;
use app\models\Category;
use Yii;
use app\models\Product;
use yii\helpers\Url;
use yii\web\Response;
use yii\widgets\ActiveForm;

class AdminController extends \Controller
{
    public function actionIndex($pageType,$limit) {
        if(Yii::$app->user->identity&& Yii::$app->user->identity->role()=='admin') {
            $data['productList'] = Product::find()
                ->alias('product')
                ->andFilterWhere(['like', 'title_en', $request->post('search')])
                ->limit(10)
                ->all();

            $menu = $this->getAdminMenu();
            $data['blocks'] = $this->getBlocks(['productMain', 'all']);
            $data['category'] = Category::find()->alias('i')->limit(20)->all();

            \Yii::$app->view->title = $data['content']->content->title;
            return $this->render('index', compact(['getAdminMenu', 'data']));
        } else {
            $this->redirect(Url::to(['user/login']), 302);
        }
    }

    public function actionCategory() {
        if(Yii::$app->user->identity) {
            $model = new BillingProcessForm();
            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            } elseif (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->validate() ) {
                $billing = new BillingProcess([
                    'user_id'   =>  Yii::$app->user->identity->id,
                    'operation' =>  $model['bill'],
                    'value'     =>  $model['funds'],
                    'status'     =>  1,
                ]);

                $user_bill = Billing::find()->where(['user_id'=> Yii::$app->user->identity->id])->one();
                $user_bill->updateCounters(['value' => -$model['funds']]);

                if($billing->validate()) {
                    $billing->save();
                }

                $this->redirect(Url::to(['user/billing']), 302);

            } else {
                $this->redirect(Url::to(['user/login']), 302);
            }
        } else {
            $this->redirect(Url::to(['user/login']), 302);
        }
    }
}