<?php
/**
 * Created by PhpStorm.
 * User: villa
 * Date: 23.11.2018
 * Time: 4:10
 */

namespace app\models;


use yii\db\ActiveRecord;

class ReviewSubImage  extends ActiveRecord
{

    public static function tableName()
    {
        return '{{yy_reviews_subimage}}';
    }

}