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

class Support extends ActiveRecord
{
	public $reCaptcha;

    public static function tableName() {
        return '{{yy_support_messages}}';
    }
	
	public function rules() { 
		return [ 
			[['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(), 'secret' => '6LcP3o4UAAAAANEhs8U2VqGFpvHtQV4AcvvW2TPi', 'uncheckedMessage' => 'Please confirm that you are not a robot.'],
			[['name', 'email','title','message'], 'required'], 
			[['name', 'title','message'],'string'],
			[['email'],'email'],
			[['status'],'integer'],
		]; 
    } 
}