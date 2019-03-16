<?php
/**
 * Created by PhpStorm.
 * User: villa
 * Date: 10.12.2018
 * Time: 22:54
 */

namespace app\models;

use Yii;
use yii\base\Model;

class BillingProcessForm extends Model
{
    public $funds;
    public $bill;

    public function rules() {
        return [
            'blank' => [['funds'], 'required', 'message'=> \Yii::t('main', 'Can`t be blank')],
            'match' => ['funds', 'match', 'pattern'=>'/[0-9]*\.[0-9]+|[0-9]+/', 'message'=> \Yii::t('main', 'Please, use numbers and point')],
            [['bill'],  'required', 'message'=> \Yii::t('main', 'Can`t be blank')],
            ['funds',  'validateWithdraw']
        ];
    }

    public function attributeLabels()
    {
        return [
            [['bill'], \Yii::t('main', 'Minimum withdraw operation') ]
        ];
    }

    public function validateWithdraw()
    {
        if (!Yii::$app->user->identity) {
            $this->addError('funds', 'Auth error. Please, login one more time.');
        }
        if ($this->funds<10) {
            $this->addError('funds', \Yii::t('main', 'Minimum - {funds}$', ['funds'=>10]));
        }
        $user_billing = Billing::find()->where(['user_id'=> Yii::$app->user->identity->id ])->one();
        if($user_billing->value < $this->funds) {
            $this->addError('funds', \Yii::t('main', 'Insufficient funds'));
        }
    }
}