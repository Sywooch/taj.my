<?php
/**
 * Created by PhpStorm.
 * User: villa
 * Date: 11.12.2018
 * Time: 2:35
 */

namespace app\models;

use yii\db\ActiveRecord;
use Yii;

class Information extends ActiveRecord
{
    public static function tableName()
    {
        return '{{yy_information}}';
    }


	public function rules() { 
		return [ 
			[['link'], 'string'], 
		]; 
    } 
	
    public function getContent()
    {
        return $this->hasOne(InformationContent::class, ['information_id' => 'id'])->alias('c')->andOnCondition(['c.lang'=>Yii::$app->language]);
    }
}