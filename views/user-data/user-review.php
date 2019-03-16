<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<?=$this->render('/site/content/header', compact('menu')); ?>
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <h1 class="pagename"><?=\Yii::t('main', 'Your Reviews Feed');?></h1>
                    <div class="product__list">
						<?php  if(count($data['reviews'])>0) { ?>
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
											<div class="label label-default">
												<?=\Yii::$app->formatter->asDate($r->create_date,'dd.MM.yyyy HH:mm')?>
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
                                        <div class=" mt-md-1">
                                            <div class="row">
                                                <div class="col-md-6"></div>
                                                <div class="col-md-3">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title text-center">
                                                                <div>Views</div>
                                                            </h3>
                                                        </div>
                                                        <div class="text-center">
                                                            <h4><?=$r->views?></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title text-center">
                                                                <div>Earned</div>
                                                            </h3>
                                                        </div>
                                                        <div class="text-center">
                                                            <h4><?=round($r->views/1000*0.9,2)?>$</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
                            <?php } else {?>
                                <?=\Yii::t('main', 'You have no reviews. To add new review, select your product.');?>
                            <?php } ?>
                        </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">
                                <?=Yii::$app->user->identity->username?>        </h3>
                        </div>
                        <div class="panel-body">
                            <div class="text-center mr-bt-1"> <?= Html::img( Yii::$app->user->identity->profile->getAvatarUrl(100), [
                                    'class' => 'img-rounded',
                                    'alt' => Yii::$app->user->identity->username,
                                ]) ?>
                            </div>
                        </div>
                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="<?=Url::to(['/user/settings/profile'])?>">Profile</a></li>
                                <li><a href="<?=Url::to(['/user/dialog'])?>">Messages</a></li>
                                <li><a href="<?=Url::to(['/user/settings/account'])?>">Account</a></li>
                                <li><a href="<?=Url::to(['/user/billing'])?>">Billing</a></li>
                                <li class="active"><a href="<?=Url::to(['/user/reviews'])?>">Reviews</a></li>
                                <li class="user-logout special" onclick="logout()"><a href="/user/settings/#">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?=$this->render('/site/content/footer', compact('menu')); ?>