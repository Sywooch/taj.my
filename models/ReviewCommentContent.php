<?php
/**
 * Created by PhpStorm.
 * User: villa
 * Date: 24.11.2018
 * Time: 17:27
 */

namespace app\models;


use yii\db\ActiveRecord;

class ReviewCommentContent extends ActiveRecord
{
    public static function tableName() {
        return '{{yy_review_comment_content}}';
    }

	public function rules() { 
		return [ 
			[['lang','content'], 'string'], 
			[['comment_id'], 'integer'], 
		]; 
    } 
}