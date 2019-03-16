<?php
/**
 * Created by PhpStorm.
 * User: villa
 * Date: 07.12.2018
 * Time: 17:27
 */

namespace app\controllers;

use app\models\Billing;
use app\models\BillingProcess;
use app\models\BillingProcessForm;
use app\models\Review;
use app\models\ReviewLikes;
use app\models\ReviewComment;
use app\models\ReviewCommentContent;
use app\models\ReviewCommentLike;
use app\models\Dialog;
use app\models\User;
use app\models\Profile;
use app\models\DialogMessage;
use app\models\DialogForm;
use app\models\DialogCreateForm;
use Yii;
use app\models\Product;
use app\models\Category;
use yii\helpers\Url;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\base\Security;
use yii\web\UploadedFile;
use yii\helpers\BaseFileHelper;



class AjaxController extends SiteController
{
	public function actions() {
		if(Yii::$app->user->identity) {
			return [
				'change-avatar' => [
					'class' 	=> 'budyaga\cropper\actions\UploadAction',
					'url' 		=> '/images/users/'.Yii::$app->user->identity->getId(),
					'type'		=> 'user_avatar',
					'path' 		=> '@app/public_html/images/users/'.Yii::$app->user->identity->getId(),
				]
			];
		}
	}
	
    public function actionProductSearch() {
        $request= Yii::$app->request;

        $result = [
            'error' => false,
            'products'  => [],
        ];
        if($request->isAjax&&$request->post('search')!='') {
			
				
            $model = Product::find()->alias('product')->andFilterWhere(['like', 'title_'.Yii::$app->language, $request->post('search')])->limit(10)->all();
            if ($model) {
                foreach ($model as $m) {
                    $category = $this->getParent($m->category_id);
                    $category_link = array_reverse($category);
                    $result['products'][] = [
                        'id' => $m->id,
                        'name' => $m->getTitle(),
                        'link' => $m->link,
                        'image' => $m->getProductImage(),
                        'category_id' => $m->category_id,
                        'category' => $category_link,
                        'url' => Url::to(['product/product', 'category_link' => $category[0]['link'], 'link' => $m->link], true)
                    ];
                }
            }
        }
        return json_encode($result);
    }
	
    public function actionCategorySearch() {
        $request= Yii::$app->request;

        $result = [
            'error' => false,
            'products'  => [],
        ];
        if($request->isAjax&&$request->post('search')!='') {
            $model = Category::find()->alias('c')->andFilterWhere(['like', 'title_'.Yii::$app->language, $request->post('search')])->limit(10)->all();
				
            if ($model&&count($model)>0) {
                foreach ($model as $m) 
				if($m) {
                    $category = $this->getParent($m->id);
                    $category_link = array_reverse($category);
                    $result['products'][] = [
                        'id' => $m->id,
                        'name' => $m->getTitle(),
                        'link' => $m->link,
                        'image' => '',
                        'category' => $category_link,
                        'url' => ''
                    ];
                }
            } else {
				$result = [
					'error' => false,
					'products'  => [],
					'search'	=> 'No data',
				];	
			}
        }
        return json_encode($result);
    }

    public function actionWithdraw() {
        if(Yii::$app->user->identity) {
            $model = new BillingProcessForm();
            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            } elseif (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->validate() ) {
                $billing = new BillingProcess([
                    'user_id'   =>  Yii::$app->user->identity->id,
                    'operation' =>  $model['bill'],
                    'value'     =>  $model['funds'],
                    'status'     =>  1,
                ]);

                $user_bill = Billing::find()->where(['user_id'=> Yii::$app->user->identity->id])->one();
                $user_bill->updateCounters(['value' => -$model['funds']]);

                if($billing->validate()) {
                    $billing->save();
                }

                $this->redirect(Url::to(['user/billing']), 302);

            } else {
                $this->redirect(Url::to(['user/login']), 302);
            }
        } else {
            $this->redirect(Url::to(['user/login']), 302);
        }
    }

    public function actionLikeReview() {
        $result['result'] = false;
        if(Yii::$app->request->isAjax && Yii::$app->user->identity) {
            $request= Yii::$app->request;
            if($request->post('review_id')>0) {

                $rev= Review::find()->where(['id'=> $request->post('review_id')])->one();
                if($rev) {
                    $like = ReviewLikes::find()
                        ->where([
                            'user_id' => Yii::$app->user->identity->getId(),
                            'review_id' => $request->post('review_id')
                        ])->one();

                    if ($like) {
                        $like->delete();

                        $l = $rev->likes-1;
                        $rev->likes = $l;
                        $rev->save(false);

                        $result['action'] = 'removed';
                        $result['result'] = true;
                    } else {
                        $like = new ReviewLikes();
                        $like->user_id = Yii::$app->user->identity->getId();
                        $like->review_id = $request->post('review_id');
                        $like->save();

                        $l = $rev->likes+1;
                        $rev->likes = $l;
                        $rev->save(false);

                        $result['action'] = 'added';
                        $result['result'] = true;
                    }
                }

            }
        }
		if(!Yii::$app->user->identity) {
			$result['logged'] = false;
		}
        return json_encode($result);
    }

    public function actionLikeComment() {
        $result['result'] = false;
		
        if(Yii::$app->request->isAjax && Yii::$app->user->identity) {
            $request= Yii::$app->request;
            if($request->post('comment_id')>0) {

                $rev= ReviewComment::find()->where(['id'=> $request->post('comment_id')])->exists();
                if($rev) {
					if($request->post('like')=="true") {
						$status = 1;
					} else {
						$status = 0;
					}
					
					$like = ReviewCommentLike::find()
                        ->where([
                            'user_id' 		=> Yii::$app->user->identity->getId(),
                            'comment_id' 	=> $request->post('comment_id')
                        ])->all();			// if for some reasons count > 1

                    if ($like) {
						foreach($like as $l)
							$l->delete();
						
                        $result['result'] = true;
						$result['action'] = 'removed';
                    }
					if($request->post('remove')=="false") {
						$like = new ReviewCommentLike();
						$like->user_id = Yii::$app->user->identity->getId();
						$like->comment_id = $request->post('comment_id');
						$like->status = $status; 
						$like->save();
						
						$result['action'] = 'added';
						$result['result'] = true;
                    }
					
					$result['countLike'] = ReviewCommentLike::find()
                        ->where([
                            'comment_id' 	=> $request->post('comment_id'),
							'status'		=> 1
                        ])->count();
					$result['countDislike'] = ReviewCommentLike::find()
                        ->where([
                            'comment_id' 	=> $request->post('comment_id'),
							'status'		=> 0
                        ])->count();
                } else {
					$result['error'] = 'No Comment';
				}

            }
        }
		if(!Yii::$app->user->identity) {
			$result['logged'] = false;
		}
        return json_encode($result);
    }
	
	public function actionAddCompare() {
        $result['result'] = false;
        if(Yii::$app->request->isAjax) {
            $request= Yii::$app->request;
            if($request->post('product_id')>0) {
                $pr= Product::find()->where(['id'=> $request->post('product_id')])->exists();
                if($pr) {
					$session = Yii::$app->session;
					if(
						isset($session['compare'])&&
						isset($session['compare'][$request->post('product_id')])&&
						$session['compare'][$request->post('product_id')]
					) {
						$compare = $session['compare'];
						
						unset($compare[$request->post('product_id')]);
						$session['compare'] = $compare;
						
						$result['count'] = count($compare);
                        $result['action'] = 'removed';
                        $result['result'] = true;
					} else {
						$compare = $session['compare'];
						if(count($compare)>1) {
							$compare = end($compare);
						}
						$compare[$request->post('product_id')] = $request->post('product_id'); 
                        
                        $session['compare'] = $compare;
                        
                        $result['count'] = count($compare);
                        $result['action'] = 'added';
                        $result['result'] = true;
                    }
                } else $result['error'] = 'No Product';

            }
        }
        return json_encode($result);
    }
	
    public function actionAddComment() {
        $result['result'] = false;
        if(Yii::$app->request->isAjax && Yii::$app->user->identity) {
            $request= Yii::$app->request;
            if($request->post('review_id')>0&&$request->post('content')!='') {

                $rev= Review::find()->where(['id'=> $request->post('review_id')])->exists();
                if($rev) {
					
					$comment = new ReviewComment();

					$comment->user_id = Yii::$app->user->identity->getId();
					$comment->review_id = $request->post('review_id');
					
					if(Yii::$app->user->identity->getId()==4) {
						$comment->status=1;
					} else {
						$comment->status=0;
					}
					
					$comment->save();
					
					$lang = ['en','ar'];
					foreach($lang as $l) {
						
						$commentContent = new ReviewCommentContent();
						
						$commentContent->comment_id = $comment->getPrimaryKey();
						$commentContent->content = $request->post('content');
						$commentContent->lang = $l;
						
						$commentContent->save();
						
						$result['result']=true;
					}
                }

            }
        }
        return json_encode($result);
    }
	
    public function actionDialog() {
        $result['result'] = false;
        if(Yii::$app->request->isAjax && Yii::$app->user->identity) {
            $request= Yii::$app->request;
            
			$model = new DialogForm;
			
            if($model->load(Yii::$app->request->post())&&$model->validate()) {
				if($model->dialog_id==0&&$model->user_to>0) {
					$d = new DialogForm;
					
					$d->load(Yii::$app->request->post());
					
					$newDialog = new Dialog;
					
					$newDialog->title = $d->title;
					$newDialog->user_to = $d->user_to;
					$newDialog->user_from = Yii::$app->user->identity->getId();
					$newDialog->save();
					
					$model->dialog_id = $newDialog->id;
					$rev = $newDialog;
					
				} else {
					$rev= Dialog::find()->where(['id'=> $model->dialog_id])->one();
				}
				$user_id = Yii::$app->user->identity->getId();
				
				if($rev&&
					( $rev->user_to == $user_id || $rev->user_from == $user_id )
				) {
				
					$msg = new DialogMessage();
					$msg->content = $model->content;
					if($rev->user_from == $user_id) {
						$msg->direction = 1;
					} else {
						$msg->direction = 0;
					}
					$msg->status = 1;
					$msg->dialog_id = $model->dialog_id;
					
					$msg->save();
					
					$rev->update_date = "CURRENT_TIMESTAMP()";
					$rev->update();
					
					$result['result'] = true;
					$result['redirect'] = Url::to(['dialog/'.$rev->id]);
                } else $result['error'] = 'U';
            } else $result['error'] = 'M';
        }
		if(!Yii::$app->user->identity) {
			$result['logged'] = false;
		}
        return json_encode($result);
    }
	
	public function actionCreateInviteCode() {
		$result['result'] = false;
		if(Yii::$app->user->identity)
		if($user_id = Yii::$app->user->identity->getId()) {
			$user = User::find()->where(['id'=>$user_id])->one();
			if($user->invite=='') {
				$key = false;
				$stop = 0;
				while($key===false) {
					$key = Yii::$app->getSecurity()->generateRandomString(32);
					if(User::find()->where(['invite'=>$key])->exists()) {
						$key = false;
					}
					if($stop>100) {
						return false; 
					} else {
						$stop++;
					}
				}
				$user->invite = $key;
				if($user->save(false)) {
					$result['result'] = true;
					$result['key'] = $key;
				} else {
					$result['error'] = $model->errors();
				}
			} else {
				$result['error'] = 'Invite code exists';
			}
		}
        return json_encode($result);
	}
	
}