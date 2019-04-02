<?php
use yii\helpers\Url;
//echo '<pre>';
//var_export($data);die;
?>
<?//=$this->render('/site/content/header', compact('menu')); ?>
<!--<main>-->
<!--    <div class="container">-->
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


            <h1 class="pagename"><?=\Yii::t('main', 'RevsFeed');?></h1>
            <div class="content">
                <div class="product__list">
                    <?php foreach($data['reviews'] as $r) {?>
                        <div class="product__list__item">
                            <div class="product__list__item__img">
                                <a class="link-item-img" href="<?= Url::to(['product/review', 'link' => $r->link, 'product_link' => $r->product->link]); ?>"><img src="<?= $r->getImage() ?>" alt=""></a>

                            </div>
                            <div class="product__info">

                                <h2>
								<?=$r->getStatus()?>

                                    <a href="<?= Url::to(['product/review', 'link' => $r->link, 'product_link' => $r->product->link]); ?>">
                                        <?= $r->getTitle() ?>
                                    </a>
								
								<?php 
								if($data['userRole']) { ?>
									<a href="/adminpanel/review/update?id=<?=$r->id?>" class="btn btn-success pull-right"><?= \Yii::t('main', 'Edit Review')?></a>
								<?php }?>
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
                                    <a href="<?=Url::to(['users/'.$r->user_id])?>" class="avatar">
                                        <img src="<?= $r->author->getAvatar(); ?>" alt="">
                                        <span><?= $r->getAuthorName();?></span>
                                    </a>
                                </div>
                                <div class="product__review">
                                       <a class="link-product-review" href="<?= Url::to(['product/review', 'link' => $r->link, 'product_link' => $r->product->link]); ?>">
                                            <span>
                                            <?php
                                            if (isset($r->reviewContentFirst)) echo $r->reviewContentFirst->getLimitedContent(500); ?>
                                            </span>
                                       </a>
                                    <?php if(isset($r->link)) { ?>
                                    <a href="<?= Url::to(['product/review', 'link' => $r->link, 'product_link' => $r->product->link]); ?>">
                                        <button class="readmore"><?= \Yii::t('main', 'RevRead')?></button>
                                    </a>
                                       <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?= \app\components\PaginationWidget::widget([
                            'path'      => 'reviews',
                            'page'      => $data['pagination']['page'],
                            'limit'     => $data['pagination']['limit'],
                            'count'     => $data['pagination']['count'],
                            'firstPath' => '/',
                            'readMore'  => 'RevMore'
                    ])?>
                </div>
                <div class="promotion__item promotion__item--horizontal"></div>
            </div>
        </div>
<!--        <div class="sidebar">-->
<!--            <div class="promotion__item promotion__item--square"></div>-->
<!--            <div class="promotion__item promotion__item--square"></div>-->
<!--            <div class="promotion__item promotion__item--square"></div>-->
<!--            <div class="promotion__item promotion__item--square"></div>-->
<!--            <div class="promotion__item promotion__item--square"></div>-->
<!--        </div>-->
<!--    </div>-->
<!--</main>-->

<?//=$this->render('/site/content/footer', compact('menu')); ?>