<?php
/**
 * Created by PhpStorm.
 * User: villa
 * Date: 17.10.2018
 * Time: 9:42
 */

namespace app\models;


use yii\db\ActiveRecord;

class Menu extends ActiveRecord
{
    public static function tableName() {
        return 'yy_menu';
    }
	
	public function rules() { 
		return [ 
			[['position', 'lang','name','link'], 'string'], 
			[['sort'], 'integer'], 
		]; 
    } 
}