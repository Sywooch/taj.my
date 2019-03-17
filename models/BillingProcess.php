<?php
/**
 * Created by PhpStorm.
 * User: villa
 * Date: 10.12.2018
 * Time: 16:38
 */

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class BillingProcess extends ActiveRecord
{
    public static function tableName() {
        return '{{cc_billing_process}}';
    }

	public function rules() { 
		return [ 
			[['operation'], 'string'], 
			[['user_id','status','value'], 'integer'],
            [['remainder',],'integer'], //остаток по счету
		]; 
    } 


    public function getStatusName()
    {
        return $this->hasOne(BillingStatusName::class, ['id' => 'status'])->alias('status');
    }

    public function getBilling()
    {
        return $this->hasOne(Billing::class, ['user_id' => 'user_id'])->alias('status');
    }
	
    public function getUser()
    {
        return $this->hasOne(Profile::class, ['user_id' => 'user_id'])->alias('user');
    }


    public function getTitle() {
        if(Yii::$app->language=='ar') {
            return $this->title_ar;
        } else {
            return $this->title_en;
        }
    }

}