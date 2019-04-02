<?php
namespace app\controllers;

use app\models\ProductForm;
use function count;
use function var_export;
use Yii;
use app\models\Category;
use app\models\Product;
use app\models\Review;
use app\models\ReviewCommentLike;
use app\models\UploadSubImageForm;
use Codeception\Lib\Interfaces\ActiveRecord;
use app\models\Block;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

class ProductController extends SiteController
{

    public function actionCategory($link,$page = 0)
    {
        $limit = 5;
        $menu = $this->getMenu();
        $data['blocks'] = $this->getBlocks(['productMain','all']);

        if($data['category_info'] = $this->getCategoryInfo($link)) {
            $id = $data['category_info']->id;
            $data['products'] = $this->getProduct($id,'',$limit, $page);
            $data['children'] = $this->getChildCategories($id);
            $data['pagination'] = [
                'path'  => 'products/'.$link,
                'count' => $this->getProductCount($id),
                'page'  => $page,
                'limit' => $limit
            ];
			$session = Yii::$app->session;
			if(isset($session['compare'])) {
				$data['compare'] = $session['compare'];
			} else {
				$data['compare'] = [];
			}
            \Yii::$app->view->title = $data['category_info']->getTitle();

            return $this->render('index', compact(['menu', 'data']));
        } else {
            $this->redirect('/',302);
            return '';
        }
    }

    public function actionReview($product_link, $link) {

        if($data['review'] = $this->getProductReview($product_link,$link)) {
			if($data['review']['reviewComment']) {
				$comment_ids = [];
				foreach($data['review']['reviewComment'] as $rC) {
					$comment_ids[] = $rC['id'];
				}
				if(Yii::$app->user->identity) {
					$data['UserCommentLikes'] = ReviewCommentLike::find()
                        ->where([
                            'user_id' 		=> Yii::$app->user->identity->getId(),
                            'comment_id' 	=> $comment_ids
                        ])->indexBy('comment_id')->all();
				} else {
					$data['UserCommentLikes'] = [];
				}
			}
            $menu = $this->getMenu();
            $data['blocks'] = $this->getBlocks(['productMain','all']);

            $data['products'] = $this->getProduct($data['review']['product']['category_id']);
			$session = Yii::$app->session;
			if(isset($session['compare'])) {
				$data['compare'] = $session['compare'];
			} else {
				$data['compare'] = [];
			}
			
            \Yii::$app->view->title = $data['review']['product']->getTitle().' - '.$data['review']->getTitle();

            $post = Review::find()
				->where(['id' => $data['review']['id']])
				->one();
            $post->updateCounters(['views' => 1]);
			
			$data['userRole'] = $this->getCheckActiveRole(); 
//			echo '<pre>'; var_export($data);
            return $this->render('review', compact(['menu', 'data']));
        } else {
            $this->redirect('/',302);
            return '';
        }
    }

    public function actionProduct($category_link, $link, $page=0) {
        if($data['category_info'] = $this->getCategoryInfo($category_link)) {
            $limit = 5;
            $menu = $this->getMenu();
            $data['blocks'] = $this->getBlocks(['productMain', 'all']);

            $id = $data['category_info']->id;

			$session = Yii::$app->session;
			if(isset($session['compare'])) {
				$data['compare'] = $session['compare'];
			} else {
				$data['compare'] = [];
			}
			
            if ($data['product'] = $this->getProduct($id, $link, 5)) {
//                echo '<pre>';
//                var_export($data['product']);die;
                $data['pagination'] = [
                        'path' => 'products/' . $link,
                        'count' => $this->getProductCount($id),
                        'page' => $page,
                        'limit' => $limit
                    ];
                \Yii::$app->view->title = $data['product']->getTitle() . ' - ' . $data['category_info']->getTitle();

                $data['productReviews'] = $this->getProductReviews($data['product']['id']);

                return $this->render('product', compact(['menu', 'data']));
            } else {
                $this->redirect('/',302);
            }
        } else {
            $this->redirect('/',302);
            return false;
        }
    }
    
    public function actionCreatenew() {
        if(Yii::$app->user->id>0) {
            $menu = $this->getMenu();

            Yii::$app->view->title = \Yii::t('main', 'Add New Product');

            $data['blocks'] = $this->getBlocks(['productMain','all']);
            $data['product_model']    = new ProductForm();
			
            return $this->render('addproduct', compact(['data', 'menu']));
        } else {
            if(Yii::$app->user->id<1) {
                $this->redirect(Url::to('user/login', true), 302);
                return false;
            } else {
                $this->redirect(Url::to('/', true), 302);
                return false;
            }
        }
        
    }

    public function actionAddreviewWithCategory() {
        if(Yii::$app->user->id>0) {
            $menu = $this->getMenu();

            Yii::$app->view->title = \Yii::t('main', 'Add New Review');

            $data['blocks'] = $this->getBlocks(['productMain','all']);
            $data['model'] = new Review();
            $data['product_model']    = new ProductForm();
            $data['model_content'] = new UploadSubImageForm();
			
			$session = Yii::$app->session;
			if(isset($session['compare'])) {
				$data['compare'] = $session['compare'];
			} else {
				$data['compare'] = [];
			}
			
            return $this->render('newreviewWithCategory', compact(['data', 'menu']));
        } else {
            if(Yii::$app->user->id<1) {
                $this->redirect(Url::to('user/login', true), 302);
                return false;
            } else {
                $this->redirect(Url::to('/', true), 302);
                return false;
            }
        }


    }

    public function actionAddreview($category_link = '', $link = '') {
        if($data['category_info'] = $this->getCategoryInfo($category_link) && Yii::$app->user->id>0) {

            $id = $data['category_info']['category']['id'];

            if($data['product'] = $this->getProduct($id,$link)) {
                $data['page'] = [
                    'category_link' => $category_link,
                    'link'          => $link,
                ];
                $data['blocks'] = $this->getBlocks(['productMain','all']);
                $menu = $this->getMenu();

                \Yii::$app->view->title = \Yii::t('main', 'Post Review for').' '.$data['product']->getTitle();

                $data['model'] = new Review();
                $data['model_content'] = new UploadSubImageForm();
				
				$session = Yii::$app->session;
				if(isset($session['compare'])) {
					$data['compare'] = $session['compare'];
				} else {
					$data['compare'] = [];
				}
			
                return $this->render('newreview', compact(['data', 'menu']));
            } else {
                $this->redirect(Url::to(['product','category_link'=>$category_link], true), 302);
                return false;
            }
        } else {
            if(Yii::$app->user->id<1) {
                $this->redirect(Url::to('product/addreview', true), 302);
                return false;
            } else {
                $this->redirect(Url::to('/', true), 302);
                return false;
            }
        }
    }

    public function getCategoryInfo($link) {
        return Category::find()
            ->alias('category')
            ->andFilterWhere(['category.link' =>$link])
            ->limit(1)
			->cache(72000)
            ->one();
    }

    public function getChildCategories($id = 0) {
        return Category::find()->where(['parent_id'=>$id])->cache(72000)->all();
    }


    function getProductReview($product_link = '',$link = '') {
        $return = Review::find()
            ->alias('review')
            ->joinWith('category')
            ->joinWith('product')
            ->joinWith('reviewContent')
			->joinWith('reviewContentSub')
			->joinWith('reviewSubImage')
			->joinWith('reviewComment')
			->joinWith('reviewCommentContent')
			->joinWith('reviewCommentLike')
			->joinWith('reviewCommentDislike')
            ->where(['review.link'=>$link,'product.link'=>$product_link]);
			
		if($this->getCheckActiveRole()) {
			// select all;
		} else {
			$return
				->andWhere(['OR',['review.user_id'=>\Yii::$app->user->identity->id], ['review.publish'=>1]]);
		}

        if(Yii::$app->user->identity) {
            $return
                ->joinWith('reviewLikesCurrent');
        }

        return $return
				->cache(720000)
				->one();
    }

    public function getProduct($category_id=0,$product_link='', $limit=5, $page=0) {
        $result = Product::find()
            ->alias('product')
            ->joinWith('category')
            ->joinWith('review review')
            ->joinWith('author')
            ->orderBy(['create_date'=> SORT_DESC]);
        if($category_id>0)
            $result
                ->where(['category_id'=>$category_id]);

        $category = $this->getChildren($category_id);
        foreach($category as $c_id) {
            $result->orWhere(['category_id'=>$c_id]);
        }
        if(Yii::$app->user->identity) {
            $result
                ->joinWith('reviewLikesCurrent');
        }
        if($product_link=='') {
            return $result
                ->groupBy('product.id')
                ->limit($limit)
                ->offset($page*$limit)
				->cache(7200)
                ->all();
        } else {
            return $result
                ->where(['product.link' => $product_link])
                ->joinWith(['reviewContent','comments', 'subImage'])
                ->limit(1)
				->cache(7200)
                ->one();
        }
    }

    public function getChildren($parent, $storage=[]) {
        $criteria = Category::find();
        $criteria->where('parent_id=:id',true);
        $criteria->params=array(':id'=>$parent);
        $model =  $criteria->cache(72000)->all();
        foreach ($model as $key) {
            $storage[$key->id] = $key->id;
            $storage = $this->getChildren($key->id,$storage);
        }
        return $storage;
    }

    public function getProductCount($category_id = 0) {
        $result = Product::find()
            ->alias('product')
            ->joinWith('category');
        if($category_id>0)
            $result
                ->where(['category_id'=>$category_id]);

        $category = $this->getChildren($category_id);
        foreach($category as $c_id) {
            $result->orWhere(['category_id'=>$c_id]);
        }
        return $result
			->cache(72000)
			->count();
    }
    function getProductReviews($id,$limit = 5,$page = 0) {
        return Review::find()
            ->alias('review')
            ->joinWith('reviewContentFirst')
            ->joinWith('product')
            ->where(['product.id'=>$id])
            ->limit($limit)
            ->offset($limit*$page)
			->cache(7200)
            ->all();
    }

    function getProductReviewsModel() {
        $return =  
			Review::find()
				->alias('review');
			if($this->getCheckActiveRole()) {
			// select all;
			} else {
				$return
					->orWhere(['review.user_id'=>\Yii::$app->user->identity->id, 'review.publish'=>1]);
			}
			$return 
				->joinWith('ReviewsContent')
				->joinWith('category')
				->joinWith(['reviewContent', 'reviewSubImage'])
				->cache(126000)
				->joinWith('product')->one();
		return $return;
    }
	
	
	public function getCheckActiveRole() {
		$roles = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->id);
		
		foreach($roles as $role) {
			if($role->name=='admin'||$role->name=='moderator') {
				return true;
			}
		}
		return false;
	}
}