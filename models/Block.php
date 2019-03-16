<?php
/**
 * Created by PhpStorm.
 * User: villa
 * Date: 17.10.2018
 * Time: 13:51
 */

namespace app\models;

use yii\db\ActiveRecord;

class Block extends ActiveRecord
{
    public static function tableName() {
        return 'yy_block';
    }
	
	public function rules() { 
		return [ 
			[['title', 'image','content','position','page_type','lang'], 'string'], 
			[['sort'], 'integer'], 
		]; 
    } 
}