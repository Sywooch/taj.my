<?php
/**
 * Created by PhpStorm.
 * User: villa
 * Date: 14.12.2018
 * Time: 22:51
 */

namespace app\models;


use yii\db\ActiveRecord;

class ReviewLikes extends ActiveRecord
{
    public static function tableName() {
        return '{{yy_review_likes}}';
    }
}