<?php
/**
 * Created by PhpStorm.
 * User: villa
 * Date: 22.11.2018
 * Time: 1:56
 */

namespace app\models;


use yii\db\ActiveRecord;

class Profile extends ActiveRecord
{
    public static function tableName() {
        return '{{profile}}';
    }
	
	public function rules() { 
		return [ 
			[['name', 'public_email','location','website','bio','avatar'], 'string'], 
		]; 
    } 
	
    public function getAvatar() {
        if($this->avatar=='')
            return '/images/users/no-avatar.png';
        else return $this->avatar;
    }

    public function getBio() {
        if($this->bio=='')
            return 'User doesn`t write about himself';
        else return $this->bio;
    }

    public function getLocation() {
        if($this->location=='')
            return 'Solar system';
        else return $this->location;
    }

}