<?php
/**
 * Created by PhpStorm.
 * User: villa
 * Date: 22.11.2018
 * Time: 20:58
 */

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Category extends ActiveRecord
{
    public static function tableName() {
        return '{{yy_category}}';
    }

	
	public function rules() { 
		return [ 
			[['title_ar','title_en','link'],'string'],
			[['parent_id'],'integer'],
		]; 
    } 
	
	
    public function getCategoryInfo() {

    }

    public function getTitle() {
        if(Yii::$app->language=='ar') {
            return $this->title_ar;
        } else {
            return $this->title_en;}
    }

    public function getName() {
        if(Yii::$app->language=='ar') {
            return $this->title_ar;
        } else {
            return $this->title_en;
        }
    }

    public function getProducts()
    {
        return $this->hasMany(Product::class, ['category_id' => 'id']);
    }

    public function getChildren($parent, $level=0) {
        $criteria = new CDbCriteria;
        $criteria->condition='parent_id=:id';
        $criteria->params=array(':id'=>$parent);
        $model = $this->findAll($criteria);
        foreach ($model as $key) {
            echo str_repeat(' — ', $level) . $key->name . "<br />";
            $this->getChildren($key->id, $level+1);
        }
    }

    public function getChildrenString($parent) {
        $criteria = new CDbCriteria;
        $criteria->condition='parent_id=:id';
        $criteria->params=array(':id'=>$parent);
        $model = $this->findAll($criteria);
        foreach ($model as $key) {
            $storage .= $key->id . ",";
            $storage .= $this->getChildrenString($key->id);
        }
        return $storage;
    }
}