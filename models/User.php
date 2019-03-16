<?php

namespace app\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    public static function tableName() {
        return '{{user}}';
    }
	
	public function rules() { 
		return [ 
			[['username', 'email','password_hash'], 'required'], 
			[['unconfirmed_email','registration_ip','auth_key','password_hash'],'string'],
			[['confirmed_at','blocked_at','created_at','updated_at'],'integer'], 
		]; 
    } 
	
    public function getBilling()
    {
        return $this->hasOne(Billing::class, ['user_id' => 'id']);
    }
}
