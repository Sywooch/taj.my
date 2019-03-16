<?php
/**
 * Created by PhpStorm.
 * User: villa
 * Date: 11.12.2018
 * Time: 2:35
 */

namespace app\models;


use yii\db\ActiveRecord;

class InformationContent extends ActiveRecord
{
    public static function tableName()
    {
        return '{{yy_information_content}}';
    }

	public function rules() { 
		return [ 
			[['lang','title','content'], 'string'], 
			[['information_id'], 'integer'], 
		]; 
    } 
}