<?php
/**
 * Created by PhpStorm.
 * User: villa
 * Date: 17.10.2018
 * Time: 13:51
 */

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class ReviewContent extends ActiveRecord
{

    public static function tableName() {
        return '{{yy_reviews_content}}';
    }


    public function getReview()
    {
        return $this->hasOne(ReviewContent::class, ['id' => 'product_id'])->where(['lang'=>Yii::$app->language]);
    }

    public function getProduct()
    {
        return $this->hasOne(ReviewContent::class, ['id' => 'product_id'])->via('review');
    }

    public function getStartContent() {
       // return $this->content;
    }
    public function getLimitedContent($limit) {
        if(isset($this->content)) {
            return \yii\helpers\StringHelper::truncate($this->content, $limit, '<span class="more_text">...</span>');
        } else {
            return '';
        }
    }
}
