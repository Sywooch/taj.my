<?php
/**
 * Created by PhpStorm.
 * User: villa
 * Date: 24.11.2018
 * Time: 17:27
 */

namespace app\models;


use yii\db\ActiveRecord;

class ReviewComment extends ActiveRecord
{
    public static function tableName() {
        return '{{yy_review_comment}}';
    }

	public function rules() { 
		return [ 
			[['create_date'], 'string'], 
			[['review_id','user_id','status'], 'integer'], 
		]; 
    } 
	
    public function getAuthor()
    {
        return $this->hasOne(Profile::class, ['user_id' => 'user_id']);
    }
	
    public function getReview()
    {
        return $this->hasOne(Review::class, ['id' => 'review_id']);
    }
	
    public function getCountComments() {
        return count($this);
    }
    
    public function getReviewCommentLike()
    {
        return $this->hasMany(ReviewCommentLike::class, ['comment_id' => 'id']);
    }
    
    public function getReviewCommentLikeCount()
    {
        return $this->hasMany(ReviewCommentLike::class, ['comment_id' => 'id'])->onCondition(['status'=>1])->count();;
    }
	
    public function getReviewCommentDislikeCount()
    {
        return $this->hasMany(ReviewCommentLike::class, ['comment_id' => 'id'])->onCondition(['status'=>0])->count();;
    }
	
	public function getReviewCommentContent() {
		return $this->hasMany(ReviewCommentContent::class, ['comment_id' => 'id']);
	}
}