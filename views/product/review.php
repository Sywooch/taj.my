<?php
use yii\helpers\Html;
use yii\helpers\Url;
/*---------------META TAGS------------------------*/
Yii::$app->meta->setMeta([
        'description' => $data['review']['product']['description'],
        'og:type'=>'profile',
        'title'=> $this->title,
        'og:image'=>"image",
        'og:site_name'=>'Tajrobtak'
    ]);
/*---------------META TAGS------------------------*/
?>
<?//=$this->render('/site/content/header', compact('menu')); ?>
<!--<main>-->
<!--    <div class="container">-->
<!--        <div class="center">-->
            <div class="info">
                <?php foreach($data['blocks']as $b) { ?>
                    <div class="info__item">
                        <img src="<?=$b->image?>" alt="<?=$b->title?>">
                        <h4><?=$b->title?></h4>
                        <span><?=$b->content?></span>
                    </div>
               <?php } ?>
            </div>

            <div class="breadcrumbs">
                <?= \app\components\BreadcrumbWidget::widget([
                    'path'          => 'ProductReview',
                    'category'      => $data['review']['product']['category'],
                    'product'      => $data['review']['product'],
                    'current'  => $data['review']->getTitle()
                ])?>
            </div>

            <h1 class="pagename"><?=$data['review']->getTitle();?></h1>
            <div class="content">
                <div class="review-container">
                    <h2 class="review-heading">
					<?=$data['review']->getStatus();?>
					<?=$data['review']['product']->getTitle()?> - <?=$data['review']['category']->getTitle()?>
					
					<?php if($data['userRole']) { ?>
						<?php if($data['review']->publish!=3) { ?>
							<a href="/adminpanel/review/update?id=<?=$data['review']['id']?>&setstatus=3" class="admin-ajax btn btn-danger pull-right"><?=\Yii::t('main', 'Block Review');?></a>
						<?php }  if($data['review']->publish!=2) { ?>
							<a href="/adminpanel/review/update?id=<?=$data['review']['id']?>&setstatus=2" class="admin-ajax btn btn-warning pull-right"><?=\Yii::t('main', 'Cancel Review');?></a>
						<?php }  if($data['review']->publish!=1) { ?>
							<a href="/adminpanel/review/update?id=<?=$data['review']['id']?>&setstatus=1" class="admin-ajax btn btn-primary pull-right"><?=\Yii::t('main', 'Publish Review');?></a>
						<?php } ?>
						<a target="_blank" href="/adminpanel/review/update?id=<?=$data['review']['id']?>" class="btn btn-default pull-right"><?=\Yii::t('main', 'Edit Review');?></a>
						
						
						<?php $this->registerJs("
						jQuery(document).ready(function() {
							jQuery('.admin-ajax ').on('click',function(ev) {
								ev.preventDefault();
								document.location =$(this).attr('href')+'&return='+document.location.href;
							});
						});
						");?>
					<?php } ?>
					</h2>
                    <div class="product__social">
                        <?= $data['review']->getShowRank()?>
                        <div class="like" attr-id="<?=$data['review']['id']?>">
                            <?php
                            if($data['review']['reviewLikesCurrent']) { ?>
                                <i class="fas fa-heart"></i>
                            <?php } else {?>
                                <i class="far fa-heart"></i>
                            <?php } ?>
                            <div class="count__like">
                                <?=$data['review']['likes'];?>
                            </div>
                        </div>
                        <div class="comment">
                            <i class="far fa-comment"></i>
                            <div class="count__comment"></div>
                        </div>
                        <div class="avatar">
                            <a href="<?=Url::to(['users/'.$data['review']['author']->user_id])?>">
                                <img src="<?=$data['review']['author']->getAvatar();?>" alt=""><span><?=$data['review']['author']->name?></span>
                            </a>
                        </div>
                        <div class="product__cost">
                            <span><?=\Yii::t('main', 'Cost');?>: <?=$data['review']->cost?></span>
                        </div>
                    </div>
                    <div class="review__inner">
                        <?=$data['review']->getContent()?>
                    </div>
                    <div class="review__footer">
                        <div class="review__footer__left">
							<?php if($data['review']['recommend_status']==1) { ?>
								<span class="author__recommend"><i class="fas fa-thumbs-up"></i>
									<?=\Yii::t('main', 'PrRrLikes');?>
								</span>
							<?php } else { ?>
								<span class="author__recommend"><i class="fas fa-thumbs-down"></i>
									<?=\Yii::t('main', 'PrRrNotLikes');?>
								</span>
							<?php }?>
                            <span class="author__experience"><i class="far fa-clock"></i><?=\Yii::t('main', 'UseExp');?>: 
							<?php 
							$exp = [
								0=>'Not Used',
								1=>'One day of use',
								2=>'Few days of use',
								3=>'One week of use',
								4=>'Month of use', 
								5=>'More than month'
							];
							echo $exp[$data['review']['use_exp']];
							?>
							</span>
                        </div>
                        <button 
                            class="author__write 
                        <?php if(Yii::$app->user->identity&&$data['review']['author']->user_id==Yii::$app->user->identity->getId()) echo ' hidden';?>" 
                            data-toggle="modal" 
                            <?php if(Yii::$app->user->identity) { ?>
                                data-target="#writeNewMsg"
                            <?php } else { ?>
                                data-target="#loginFirstModal"
                            <?php }?>
                            attr-id="<?=$data['review']['author']->user_id?>">
                            <?=\Yii::t('main', 'RevRrWriteTo');?>
                        </button>
                    </div>
                    <div class="review__actions product__social">
						<?php if($data['review']['reviewLikesCurrent']) { ?>
							<span class="review__add__like like" attr-id="<?=$data['review']['id']?>">
								<i class="fas fa-heart"></i><?=\Yii::t('main', 'Likes');?> 
								+<span>
									<span class="count__like"><?=$data['review']['likes']?></span></span>
							</span>
						<?php } else { ?>
							<span class="review__add__like like" attr-id="<?=$data['review']['id']?>">
								<i class="far fa-heart"></i><?=\Yii::t('main', 'Likes');?> 
								+<span><?=$data['review']['likes']?></span>
							</span>
						<?php } ?>
                        <span class="review__alert" data-toggle="modal" data-target="#reportModal"><i class="fas fa-exclamation-triangle"></i><?=\Yii::t('main', 'Report');?></span>
                        <span class="review__date"><i class="far fa-calendar-alt"></i><?=\Yii::t('main', 'Publish');?> <?=Yii::$app->formatter->asDatetime($data['review']->create_date, 'php:d F Y H:m')?></span>
                        <span class="review__compare"
                            attr-id="<?=$data['review']['product']['id']?>"
                            attr-added="<?=\Yii::t('main', 'PrCompare');?>"
                            attr-removed="<?=\Yii::t('main', 'PrCompareRemove');?>"
                        >
                            <i class="fas fa-signal"></i>
                            <?php if(isset($data['compare'])&&in_array($data['review']['product']['id'], $data['compare'])) { ?>
                                <span><?=\Yii::t('main', 'PrCompareRemove');?></span>
                            <?php } else { ?>
                                <span><?=\Yii::t('main', 'PrCompare');?></span>
                            <?php } 
							?>
                        </span>
                    </div>
                    <div class="promotion__item promotion__item--horizontal"></div>
                    <div class="review__list__wrap" id="comments">
                        <h2 class="pagename"><?=\Yii::t('main', 'OtherComments');?></h2>
                        <?php if(Yii::$app->user->isGuest) {?>
                            <?= Yii::t('main', 'Please') .' '.Html::a( Yii::t('main', 'login'), ['user/login'], ['class' => 'login-link']).' '.Yii::t('main', 'toWriteComment') ?>
                        <?php } else {?>
                            <button class="add__comment"><?=\Yii::t('main', 'WriteComment');?></button>
                            <div class="new_comment" style="display:none">
                                <div class="row">
									<div class="col-md-9">
										<textarea id="NewCommentText" class="form-control" rows="5" placeholder="<?=\Yii::t('main', 'Your comment');?>"></textarea>
									</div>
									<div class="col-md-3">
										<div id="addNewComment" class="btn btn-block btn-success" attr-id="<?=$data['review']['id']?>">
											<?=\Yii::t('main', 'Add Comment');?>
										</div>
									</div>
								</div>
                            </div>
                            <div class="new__comment__alert alert alert-success" role="alert" style="display:none;">
                              <strong>Success!</strong> Now your comment under moderation. It will be shown soon.
                            </div>
                        <?php } ?>
                        <div class="review__list">
                        <?php
                        if(count($data['review']['reviewComment'])<1) {
                            echo Yii::t('main', 'No comments for this review. You can be first!');
                        } else foreach($data['review']['reviewComment'] as $c) { ?>
                            <div class="review__list__item" attr-id="<?=$c->id?>">
                                <div class="review__list__item__top">
									<div class="avatar">
										<a href="<?=Url::to(['users/'.$c['author']->user_id])?>">
											<img src="<?=$c->author->getAvatar()?>" alt=""><span><?=$c['author']['name']?></span>
										</a>
									</div>
                                    <div class="review__list__btn" attr-id="<?=$c->id?>">
                                        <?=Yii::$app->formatter->asDatetime($c->create_date, 'php:d F Y H:m')?>
                                        <div class="like_comment_block">
											<span class="like__comment<?php if($data['UserCommentLikes'][$c->id]&&$data['UserCommentLikes'][$c->id]['status']==1) echo ' active';?>">
												<i class="far fa-thumbs-up"></i>
												<i class="active fa fa-thumbs-up"></i>
												<span class="count"><?=$c->getReviewCommentLikeCount();?></span>
											</span>
											<span class="like__diss<?php if($data['UserCommentLikes'][$c->id]&&$data['UserCommentLikes'][$c->id]['status']==0) echo ' active';?>">
												<i class="far fa-thumbs-down"></i>
												<i class="active fa fa-thumbs-down"></i>
												<span class="count"><?=$c->getReviewCommentDislikeCount();?></span>
											</span>
										</div>
                                    </div>
                                </div>
                                <p><?=$c->reviewCommentContent[0]->content;?></p>
                            </div>
                        <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="product__list">
                    <?php
                    if(isset($data['products']))
                    foreach($data['products'] as $p) { ?>
                        <div class="product__list__item">
                            <div class="product__list__item__img">
                                <img src="<?=$p->image;?>" alt="">
                            </div>
                            <div class="product__info">
                                <h2><?=$p->getTitle(); ?></h2>
                                <?=$p->getShowStars();?>
                                    <span class="product__star__desc">
                                        <?=$p->getShowAvgRank()?><?=$p->getReviewCountText()?>
                                    </span>
                                <div class="product__cat__btn">
                                    <a href="<?=Url::to(['product/addreview','category_link'=>$p['category']->link,'link'=>$p->link,'new'=>'addreview'], true);?>" title="">
                                        <button class="product__cat__add-review"><?=\Yii::t('main', 'RevWrite');?></button>
                                    </a>
                                    <?php if($p->count_reviews) { ?>
                                        <a href="<?=Url::to(['product/'.$p['category']->link.'/'.$p->link], true);?>" title="">
                                            <button class="product__cat__read-review"><?=\Yii::t('main', 'RevRead');?> (<span><?=$p->count_reviews?></span>)</button>
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="promotion__item promotion__item--horizontal"></div>
            </div>
<!--        </div>-->
<!--        <div class="sidebar">-->
<!--            <div class="promotion__item promotion__item--square"></div>-->
<!--            <div class="promotion__item promotion__item--square"></div>-->
<!--            <div class="promotion__item promotion__item--square"></div>-->
<!--            <div class="promotion__item promotion__item--square"></div>-->
<!--            <div class="promotion__item promotion__item--square"></div>-->
<!--        </div>-->
<!--    </div>-->
<!--</main>-->
<?php
    $this->registerJs("
$('button.add__comment').on('click',function(e) {
	e.preventDefault();
	$(this).hide(200);
	$('.new__comment__alert').hide();
	$('.new_comment').show(200);
});	
$('#addNewComment').on('click',function() {
	if($('#NewCommentText').val()!='') {
		$(this).closest('.new_comment').removeClass('has-error');
		$.ajax({
			url: '/ajax/add-comment',
			type: 'POST',
			dataType: 'json',
			data: {
				'content': $('#NewCommentText').val(),
				'review_id': $(this).attr('attr-id')
			}, 
			success: function(data) {
            	$('.new__comment__alert').show(200);
            	$('.new_comment').hide(200);
			//	window.location.href += '#comments';
				//location.reload();
			}
		
		});
		
	} else {
		$(this).closest('.new_comment').addClass('has-error');
	}
});

");?>

<?=$this->render('/site/content/footer', compact('menu')); ?>