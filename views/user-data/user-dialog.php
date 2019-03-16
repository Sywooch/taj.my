<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<?=$this->render('/site/content/header', compact('menu')); ?>
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <h1 class="pagename"><?=\Yii::t('main', 'Your Dialogs');?></h1>
                    <?php  if(count($data['dialogs'])>0) { ?>
                        <table class="table dialog__list">
                            <?php foreach($data['dialogs'] as $d) {?>
								<tr>
									<td class="text-center">
										<?php if($d['profileTo']['user_id']!=Yii::$app->user->identity->id) {?>
				                            <a href="<?= Url::to(['users/'. $d->profileTo->user_id]); ?>">							
    											<img class="img-thumbnail" src="<?=$d->profileTo->getAvatar()?>" alt="">
    											<?=$d['profileTo']['name']?>
											</a>
										<?php } else { ?>
										    <a href="<?= Url::to(['users/'. $d->profileFrom->user_id]); ?>">							
    											<img class="img-thumbnail" src="<?=$d->profileFrom->getAvatar()?>" alt="">
    											<?=$d['profileFrom']['name']?>
											</a>
										<?php } ?>
									</td>
									<td>
										<a href="<?= Url::to(['dialog/'. $d->id]); ?>">
											<h4><?=$d['title']?>
											<div class="btn btn-success btn-sm count-msg"><?=count($d['dialogMessage'])?></div>
											</h4>
										</a>
										<div>
											<div class="message">
												<?=$d['dialogMessage'][0]->getLimitedContent(600)?>
											</div>
										</div>
									</td>
							<?php } ?>
                        </table>
					<?php } else {?>
						<?=\Yii::t('main', 'You have no dialogs. When you will write some one - this dialog will be here');?>
					<?php } ?>
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
                                <li class="active"><a href="<?=Url::to(['/user/dialog'])?>">Messages</a></li>
                                <li><a href="<?=Url::to(['/user/settings/account'])?>">Account</a></li>
                                <li><a href="<?=Url::to(['/user/billing'])?>">Billing</a></li>
                                <li><a href="<?=Url::to(['/user/reviews'])?>">Reviews</a></li>
                                <li class="user-logout special" onclick="logout()"><a href="/user/settings/#">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?=$this->render('/site/content/footer', compact('menu')); ?>