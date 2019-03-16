<?php
/**
 * Created by PhpStorm.
 * User: villa
 * Date: 21.11.2018
 * Time: 19:39
 */

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Product extends ActiveRecord
{
/*
    public $title_en;
    public $title_ar;
    public $image;
    public $link;
    public $description;
    public $count_reviews;
    public $category_id;
*/



    public static function tableName() {
        return '{{yy_products}}';
    }

	public function rules() { 
		return [ 
			[['title_en', 'title_ar','link','description'], 'string'], 
			[[ 'category_id','created_by_user','status'],'integer'], 
		]; 
    } 
	
    public function getTitle() {
		if($this) {
			if(Yii::$app->language=='ar') {
				return $this->title_ar;
			} else {
				return $this->title_en;}
		} else return '';
    }


    public function getReviews()
    {
        return $this
            ->hasMany(Review::class, ['product_id' => 'id'])
            ->onCondition([Review::tableName().'.publish'=>1]);
    }

    public function getReview()
    {
        return $this->hasOne(Review::class, ['product_id' => 'id']);
    }

    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getAuthor()
    {
        return $this->hasOne(Profile::class, ['user_id' => 'user_id'])->alias('author')->via('reviews');
    }

    public function getReviewContentFirst()
    {
        return $this->hasOne(ReviewContent::class, ['review_id' => 'id'])->alias('content')->orderBy('content.sort')->andOnCondition(['content.lang'=>Yii::$app->language]);
    }

    public function getReviewContentsFirst()
    {
        return $this->hasOne(ReviewContent::class, ['review_id' => 'id'])->
                alias('contents')->
                orderBy('contents.sort')->
                andOnCondition(['contents.lang'=>Yii::$app->language])->
                via('reviews');
    }

    public function getReviewContent()
    {
        return $this->hasMany(ReviewContent::class, ['review_id' => 'id'])->alias('content')
            ->orderBy('content.sort')
            ->andOnCondition(['content.lang'=>Yii::$app->language]);
    }

    public function getSubImage()
    {
        return $this->hasMany(ReviewSubImage::class,['review_id'=>'review_id'])->via('reviewContent');
    }

    public function getComments()
    {
        return $this->hasMany(ReviewComment::class, ['review_id' => 'review_id'])
            ->alias('comment')
            ->joinWith('author comment_author')
            ->orderBy('comment.create_date')
            ->via('reviewContent');
    }

    public function getReviewLikes()
    {
        return $this->hasMany(ReviewLikes::class, ['review_id' => 'id'])
            ->via('reviews');
    }
    public function getReviewLikesCurrent()
    {
        return $this->hasMany(ReviewLikes::class, ['review_id' => 'id'])
            ->alias('likes')
            ->via('reviews')
            ->andOnCondition(['likes.user_id' => Yii::$app->user->identity->getId()]);
    }

    public function likedReviews() {
        $count = Review::find()->where([
            'product_id'=>$this->id,
            'recommend_status' => 1,
            ])->count();
        if($count>0) {
            return $count.' '.Yii::t('app', 'recomendation');
        } else {
            return 0;
        }
    }

    public function getShowStars($stars=5) {
        $result ='<div class="product__star product__star--category">';
        for($i=1;$i<=$this->avg_rank;$i++) {
            $result.='<i class="fas fa-star"></i>';
        }
        for($i=$stars;$i>$this->avg_rank;$i--) {
            $result.='<i class="far fa-star"></i>';
        }
        $result.='</div>';
        return $result;
    }

    public function getShowStarsSmall($stars=5) {
        $result ='<div class="product__star">';
        for($i=1;$i<=$this->rank;$i++) {
            $result.='<i class="fas fa-star"></i>';
        }
        for($i=$stars;$i>$this->rank;$i--) {
            $result.='<i class="far fa-star"></i>';
        }
        $result.='</div>';
        return $result;
    }

    public function getReviewCountText() {
        if(
			(
				$this->count_reviews==0
				&& 
				count($this->reviews)== $this->count_reviews
			)
			||
			(
				count($this->reviews)!= $this->count_reviews
				&&
				count($this->reviews)==0
			)
		) {
            return Yii::t('app', 'No reviews');
        } elseif(
			(
				$this->count_reviews==1
				&& 
				count($this->reviews)== $this->count_reviews
			)
			||
			(
				count($this->reviews)!= $this->count_reviews
				&&
				count($this->reviews)==1
			)
		) {
            return Yii::t('app', ' (1 review)');
        } else {
			
            return Yii::t('app', ' ({0} reviews)', count($this->reviews));
        }
    }

    public function getShowAvgRank() {
        if($this->avg_rank==0) {
            return '';
        } elseif($this->avg_rank==1) {
            return Yii::t('app', 'Average 1 star');
        } else {
            return Yii::t('app', 'Average {0} stars', $this->avg_rank);
        }
    }

    public function getProductImage() {
        if($this->image=='') {
            return '/images/product/no-image.png';
        } else {
            return $this->image;
        }
    }
}