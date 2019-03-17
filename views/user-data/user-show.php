<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<?=$this->render('/site/content/header', compact('menu')); ?>
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <h1 class="pagename"><?=$data['user']->name?></h1>

                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-4">Name</div>
                                        <div class="col-md-8">
                                            <?=$data['user']->name?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">Location</div>
                                        <div class="col-md-8">
                                            <?=$data['user']->getLocation()?>
                                        </div>
                                    </div>
                                    <?php if($data['user']->website!='') {?>
                                    <div class="row">
                                        <div class="col-md-4">Website</div>
                                        <div class="col-md-8">
                                            <?=$data['user']->website?>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="row">
                                        <div class="col-md-4">About</div>
                                        <div class="col-md-8">
                                            <?=$data['user']->getBio()?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 text-right">
                                    <?= Html::img( $data['user']->getAvatar(), [
                                        'class' => 'img-rounded',
                                        'alt' => $data['user']->name,
                                    ]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h2><?= \Yii::t('main', 'User reviews')?></h2>

                    <?php  if(count($data['reviews'])>0) { ?>
                        <div class="product__list">
                            <?php foreach($data['reviews'] as $r) {?>
                                <div class="product__list__item">
                                    <div class="product__list__item__img">
                                        <img src="<?= $r->getImage() ?>" alt="">
                                    </div>
                                    <div class="product__info">
                                        <h2>
                                            <?php if($r->publish==1) { ?>
                                                <div class="btn btn-success float-right"><?= \Yii::t('main', 'Published')?></div>
                                            <?php } elseif($r->publish==0) { ?>
                                                <div class="btn btn-warning float-right"><?= \Yii::t('main', 'On moderate')?></div>
                                            <?php }  elseif($r->publish==2) { ?>
                                                <div class="btn btn-warning float-right"><?= \Yii::t('main', 'Removed')?></div>
                                            <?php } ?>
                                            <?= $r->getTitle() ?>
                                        </h2>

                                        <div class="product__social">
                                            <?= $r->getShowRank(); ?>
                                            <div class="like">
                                                <i class="fas fa-heart"></i>
                                                <div class="count__like"><?= $r->likes ?></div>
                                            </div>
                                            <div class="comment">
                                                <i class="far fa-comment"></i>
                                                <div class="count__comment"><?= count($r->reviewComment) ?></div>
                                            </div>
                                        </div>
                                        <div class="product__review">
                                            <span>
                                                <?php
                                                if (isset($r->reviewContentFirst)) echo $r->reviewContentFirst->getLimitedContent(500); ?>
                                            </span>
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
                                'path'      => 'users/'.$data['user']->user_id,
                                'page'      => $data['pagination']['page'],
                                'limit'     => $data['pagination']['limit'],
                                'count'     => $data['pagination']['count'],
                                'firstPath' => 'users/'.$data['user']->user_id,
                                'readMore'  => 'RevMore'
                            ])?>
                            <?php } else {?>
                                <?=\Yii::t('main', 'You have no reviews. To add new review, select your product.');?>
                            <?php } ?>
                        </div>
                </div>
                <div class="col-md-3">
                    <div class="promotion__item promotion__item--square"></div>
                    <div class="promotion__item promotion__item--square"></div>
                    <div class="promotion__item promotion__item--square"></div>
                    <div class="promotion__item promotion__item--square"></div>
                    <div class="promotion__item promotion__item--square"></div>
                </div>
            </div>
        </div>
<?=$this->render('/site/content/footer', compact('menu')); ?>