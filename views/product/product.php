<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?=$this->render('/site/content/header', compact('menu')); ?>
<main>
    <div class="container">
        <div class="center">
            <div class="info">
                <?php foreach($data['blocks'] as $b) { ?>
                    <div class="info__item">
                        <img src="<?=$b->image?>" alt="<?=$b->title?>">
                        <h4><?=$b->title?></h4>
                        <span><?=$b->content?></span>
                    </div>
               <?php } ?>
            </div>

            <div class="breadcrumbs">
                <?= \app\components\BreadcrumbWidget::widget([
                    'path'          => 'product',
                    'category'      => $data['product']['category'],
                    'product'      => $data['product'],
                    'current'  => $data['product']->getTitle()
                ])?>
            </div>

            <h1 class="pagename"><?=$data['product']->getTitle();?></h1>
            <div class="content">
                <div class="review-container">
                    <div class="product__list__item">
                        <div class="product__list__item__img">
                            <img src="<?=$data['product']->image?>" alt="">
                        </div>
                        <div class="product__info">
                            <h2 class="review-heading">
								<?=$data['product']->getTitle()?>
							</h2>
                            <div class="product__social">
                                <?= $data['product']->getShowStars()?>
                                <div class="like_type2">
                                    <i class="fas fa-heart"></i>
                                    <div class="count__like"><?=$data['product']->likedReviews();?></div>
                                </div>
                                <div class="comment">
                                    <i class="far fa-comment"></i>
                                    <div class="count__comment"><?=$data['product']->avg_rank?></div>
                                </div>
                                <div>
                                <a href="<?=Url::to(['product/addreview','category_link'=>$data['product']['category']->link,'link'=>$data['product']->link,'new'=>'addreview'], true);?>" title="">
                                    <button class="btn btn-success"><?=\Yii::t('main', 'RevWrite');?></button>
                                </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="product__list">
                    <?php
                    if(count($data['productReviews'])>0) {
                        foreach ($data['productReviews'] as $r) { ?>
                            <div class="product__list__item">
                                <div class="product__list__item__img">
                                    <img src="<?= $r->getImage(); ?>" alt="">
                                </div>
                                <div class="product__info">
                                    <h2>
										<?=$r->getStatus()?>
										<?= $r->getTitle() ?>
									</h2>

                                    <div class="product__social">
                                        <?= $r->getShowRank(); ?>
                                        <div class="like" attr-id="<?=$r['id']?>">
                                            <?php
                                            if($r['reviewLikesCurrent']) { ?>
                                                <i class="fas fa-heart"></i>
                                            <?php } else {?>
                                                <i class="far fa-heart"></i>
                                            <?php } ?>
                                            <div class="count__like">
                                                <?=$r['likes'];?>
                                            </div>
                                        </div>
                                        <div class="comment">
                                            <i class="far fa-comment"></i>
                                            <div class="count__comment"><?= count($r->reviewComment) ?></div>
                                        </div>
                                        <div class="avatar">
                                            <a href="<?=Url::to(['users/'.$r->author->user_id])?>">
                                                <img src="<?= $r->author->getAvatar(); ?>" alt=""><span><?= $r->author->name; ?></span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product__review">
                                    <span>
                                        <?php
                                        if (isset($r->reviewContentFirst)) echo $r->reviewContentFirst->getLimitedContent(500); ?>
                                    </span>
                                        <a href="<?= Url::to(['product/review', 'link' => $r->link, 'product_link' => $r['product']->link]); ?>">
                                            <button class="readmore"><?= \Yii::t('main', 'RevRead') ?></button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    } else { ?>
                        <h3 class="text-center">
                        <?=\Yii::t('main', 'No Reviews. You can be first! <a href="{link}" class="btn btn-success" title="Write Review">Write Review</a>',
                            [
                                'link'=>Url::to([
                                    'product/addreview',
                                    'category_link'=>$data['product']['category']->link,
                                    'link'=>$data['product']->link,
                                    'new'=>'addreview'
                                ], true)
                            ]);?>
                    <?php } ?></h3>
                    <?= \app\components\PaginationWidget::widget([
                        'path'      => 'reviews',
                        'page'      => $data['pagination']['page'],
                        'limit'     => $data['pagination']['limit'],
                        'count'     => $data['pagination']['count'],
                        'firstPath' => '/',
                        'readMore'  => 'RevMore'
                    ])?>
                    <div class="promotion__item promotion__item--horizontal"></div>
                </div>
            </div>
        </div>
        <div class="sidebar">
            <div class="promotion__item promotion__item--square"></div>
            <div class="promotion__item promotion__item--square"></div>
            <div class="promotion__item promotion__item--square"></div>
            <div class="promotion__item promotion__item--square"></div>
            <div class="promotion__item promotion__item--square"></div>
        </div>
    </div>
</main>

<?=$this->render('/site/content/footer', compact('menu')); ?>