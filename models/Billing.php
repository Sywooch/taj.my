<?php
/**
 * Created by PhpStorm.
 * User: villa
 * Date: 10.12.2018
 * Time: 16:38
 */

namespace app\models;

use yii\db\ActiveRecord;

class Billing extends ActiveRecord
{
    public $operation;
    public $create_date;

	public function rules() { 
		return [ 
			[['value'], 'string'], 
			[['user_id'], 'integer'], 
		]; 
    } 

    public static function tableName() {
        return '{{cc_billing}}';
    }


    public function getTitle() {
        if(Yii::$app->language=='ar') {
            return $this->title_ar;
        } else {
            return $this->title_en;
        }
    }
	
    public function getUser()
    {
        return $this->hasOne(Profile::class, ['user_id' => 'user_id'])->alias('user');
    }

}