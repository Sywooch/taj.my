<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?=$this->render('/site/content/header', compact('menu')); ?>
<?php
//echo '<pre>';
//var_export($data['dialog']['dialogMessage']);die;
?>
        <div class="container">
            <div class="row">
                <div class="col-md-9">
					<div class="card dialog__list">
						<div class="card-body">
							<div class="card-text">
								<div class="row">
									<div class="col-md-4">
										<a href="<?= Url::to(['users/'. $data['dialog']->profileTo->user_id]); ?>">							
											<img class="img-thumbnail" src="<?=$data['dialog']->profileTo->getAvatar()?>" alt="">
											<?=$data['dialog']['profileTo']['name']?>
										</a>
									</div>
									<div class="col-md-4">
										<h5><?=$data['dialog']['title']?></h5>
									</div>
									<div class="col-md-4">
										<a href="<?= Url::to(['users/'. $data['dialog']->profileFrom->user_id]); ?>">							
											<img class="img-thumbnail" src="<?=$data['dialog']->profileFrom->getAvatar()?>" alt="">
											<?=$data['dialog']['profileFrom']['name']?>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="dialog__content">
						<?php foreach($data['dialog']['dialogMessage'] as $m) { ?>
							<div><div class="dialog_box<?php if($m->direction == 1) echo ' from';?>">
								<?=$m->content?>
								<div class="sub_dialog_row">
									<?php
									if($m->create_date>0) {
										echo Yii::$app->formatter->asDate($m->create_date, 'dd.MM.yyy HH:mm');
									}?>
								</div>
							</div></div>
						<?php } ?>
					</div>
					<div class="dialog__form">
                        <?php $form = ActiveForm::begin([
                            'id' => 'dialog-form',
                            'action'    => '/ajax/dialog',
                        ]) ?>
                            <div class="row"><div class="col-md-9">
                            <?= $form->field($data['form'], 'content')->textarea(['rows' => '3'])->label(false) ?>
                            <?= $form->field($data['form'], 'dialog_id')
                                ->hiddenInput(['value'=>$data['dialog']['id']])
                                ->label(false); ?>
                            </div><div class="col-md-3">
                                <div class="btn btn-block btn-success" id="send_msg"><?=\Yii::t('main', 'Send');?></div>
                            </div></div>
                         <?php ActiveForm::end() ?>
					</div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">
                                Admin        </h3>
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