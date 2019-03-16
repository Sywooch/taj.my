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

class Review extends ActiveRecord
{

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
/*
    public $user_id;
    public $product_id;
    public $title_en;
    public $title_ar;
    public $content;
    public $cost;
    public $rank;
    public $img_main;

    public $description;
*/


    public function rules() {
		$roles = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->id);
		$activeRole = false;
		foreach($roles as $role) {
			if($role->name=='admin'||$role->name=='moderator') {
				$activeRole = true;
			}
		}	
		if($activeRole) {
			if(Yii::$app->request->get('setstatus')>0) {
				return [[['publish'],'string'],];
			} else
			return [
				[['recommend_status','link','title_en','title_ar','rank','cost'],'string'],
				[['publish','product_id','publish'],'integer'],
			];
		} else {
			return [
				[['product_id','title_en','title_ar'],'required'],
				[['recommend_status','link','rank','cost'],'string'],
				[['img_main'], 'file', 'skipOnEmpty' => false, 'extensions' => 'gif, jpg, png'],
			];
		}
    }


    public function upload()
    {
        if ($this->validate()) {
         //   $this->img_main->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }

    public function attributeLabels()
    {
        return [
            'title_en' => 'Title',
            'rank' => 'Rank',
            'cost' => 'Purchase Price',
        ];
    }

    public static function tableName() {
        return '{{yy_reviews}}';
    }

    public function setDateFormat($value)
    {
        $this->created = strtotime($value);
    }

    public function getTitle() {
        if(Yii::$app->language=='ar') {
            return $this->title_ar;
        } else {
            return $this->title_en;
        }
    }

    public function comment_count_int() {
        if(isset($this))
            return count($this);
        else
            return 0;
    }

    /*      LINKS       */

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id'])->alias('product');
    }

    public function getAuthor()
    {
        return $this->hasOne(Profile::class, ['user_id' => 'user_id'])->alias('author');
    }

    public function getReviewContentFirst()
    {
        return $this->hasOne(ReviewContent::class, ['review_id' => 'id'])->alias('rc')->orderBy('rc.sort')->andOnCondition(['rc.lang'=>Yii::$app->language]);
    }

    public function getReviewContent()
    {
        return $this->hasMany(ReviewContent::class, ['review_id' => 'id'])->alias('rc')->orderBy('rc.sort')->andOnCondition(['rc.lang'=>Yii::$app->language]);
    }

    public function getReviewContentSub()
    {
        return $this->hasMany(ReviewContent::class, ['review_id' => 'id'])->alias('rc2')->orderBy('rc2.sort')
			->andOnCondition('rc2.lang !="'.Yii::$app->language.'"');
    }

    public function getReviewSubImage()
    {
        return $this->hasMany(ReviewSubImage::class, ['review_id' => 'id'])->alias('rc_si')->orderBy('rc_si.sort');
    }


    public function getReviewLikes()
    {
        return $this->hasMany(ReviewLikes::class, ['review_id' => 'id']);
    }
    public function getReviewLikesCurrent()
    {
        return $this->hasMany(ReviewLikes::class, ['review_id' => 'id'])
            ->alias('likes')
            ->andOnCondition(['likes.user_id' => Yii::$app->user->getId()]);
    }
    
    public function getReviewCommentContent()
    {
        return $this->hasMany(ReviewCommentContent::class, ['comment_id' => 'id'])
			->andOnCondition([ 'commentContent.lang'=> Yii::$app->language])
            ->alias('commentContent')
            ->via('reviewComment');
    }
	
    public function getReviewCommentLike()
    {
        return $this->hasMany(ReviewCommentLike::class, ['comment_id' => 'id'])
			->andOnCondition([ 'commentLike.status'=> 1])
            ->alias('commentLike')
            ->via('reviewComment');
    }
    public function getReviewCommentDislike()
    {
        return $this->hasMany(ReviewCommentLike::class, ['comment_id' => 'id'])
			->andOnCondition(['commentDislike.status'=> 0])
            ->alias('commentDislike')
            ->via('reviewComment');
    }

    public function getReviewCommentLikeUser()
    {
		if(\Yii::$app->user->identity) {
			$user_id = \Yii::$app->user->identity->id;
			return $this->hasMany(ReviewCommentLike::class, ['comment_id' => 'id'])
				->andOnCondition(['commentUserLikeStatus.user_id'=> $user_id ])
				->alias('commentUserLikeStatus')
				->via('reviewComment');
		} else {
			return [];
		}	
    }
	
    public function getReviewComment()
    {
		$return = $this->hasMany(ReviewComment::class, ['review_id' => 'id'])
			->alias('comments')
			->orderBy('comments.create_date');
			
		
		if(\Yii::$app->user->identity) {
			$user_id = \Yii::$app->user->identity->id;
			$roles = Yii::$app->authManager->getRolesByUser($user_id);
			$activeRole = false;
			foreach($roles as $role) {
				if($role->name=='admin'||$role->name=='moderator') {
					$activeRole = true;
				}
			}	
			
			if(!$activeRole) {
				$return
					->onCondition(['comments.status'=>1])
					->orOnCondition(['comments.user_id' => $user_id]);
			} 
		}
		return $return;
    }

    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id'])->alias('category')->via('product');
    }

    public function getImage() {
        if($this->img_main!='') {
            return '/images/reviews/'. $this->user_id.'/' .$this->id .'/'. $this->img_main;
        }
        elseif($this->product['image']!='') return $this->product->image;
        else return '/image/products/no-image.png';
    }

    public function getStatus() {
        switch($this->publish) {
			case 0: return '<div class="btn btn-warning float-right">On moderate</div>';
			case 1: return '';
			case 2: return '<div class="btn btn-warning float-right">Canceled</div>';;
			case 3: return '<div class="btn btn-danger float-right">Removed</div>';
			
		}
    }

    public function getShowRank($stars=5) {
        $result = '<div class="product__star">';
        if(isset($this->rank )&&$this->rank >0) {
            for ($i = 1; $i <= $this->rank; $i++) {
                $result .= '<i class="fas fa-star"></i>';
            }
            for ($i = $stars; $i > $this->rank; $i--) {
                $result .= '<i class="far fa-star"></i>';
            }
        } else {
            for ($i = 0; $i > 5; $i++) {
                $result .= '<i class="far fa-star"></i>';
            }
        }
        $result .= '</div>';
        return $result;
    }

    public function getAuthorAvatar() {
        if(isset($this->author->avatar)) {
            return $this->author->avatar;
        } else {
            return '/images/users/no-avatar.png';
        }
    }
	
    public function getReviewsIncome() {
        if($this->views>0) {
            return round($this->views/180,2);
        } else {
            return 0;
        }
    }

    public function getAuthorName() {
        if(isset($this->author->name)) {
            return $this->author->name;
        } else {
            return 'New User';
        }
    }
	
	public function getContent() {
		if(isset($this['reviewContent'])&&$this['reviewContent']) {
			$content_list = $this['reviewContent'];
		} elseif(isset($this['reviewContentSub'])&&$this['reviewContentSub']) {
			$content_list = $this['reviewContentSub'];
		} else $content_list = false;
		
		if($content_list) {
			$content = [];
			foreach ($content_list as $c) {
				$content[] = '<p>' . $c->content . '</p>';
				foreach ($this['reviewSubImage'] as $k=>$img) {
					if ($img['content_index_after'] <= $c->sort) {
						$content[] = '<img src="/images/reviews/' . $this['user_id'] . '/' . $this['id'] . $img->image . '" alt="">';
						unset($this['reviewSubImage'][$k]);
					}
				}
			}
			foreach ($this['reviewSubImage'] as $k=>$img) {
				$content[] = '<img src="/images/reviews/' . $this['user_id'] . '/' . $this['id'] . $img->image . '" alt="">';
			}
			
			foreach ($content as $c) {
				$return .=  $c;
			}
			
			return $return;
		} 
		return '';

	}
}