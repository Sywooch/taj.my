<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?=$this->render('/site/content/header', compact('menu')); ?>
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <h1 class="pagename"><?=\Yii::t('main', 'Your Transactions');?></h1>
                        <div class="row" style="margin-bottom:20px;">
                            <div class="col-md-3">
                                <div class="card balance">
                                    <div class="card-body">
                                        <h5 class="card-title"><?=\Yii::t('main', 'Balance');?></h5>
                                        <div class="card-text"><?=round($data['billing']->value,2)?>$</div>
                                        <p class="sub-text">
                                            <?=\Yii::t('main', 'You can order a payment if the balance is more than <span id="withdrwa_process_min_value">{value}</span>$', ['value'=>10]);?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                    <?php $form = ActiveForm::begin([
                                        'id' => 'withdraw-form',
                                        'action'    => '/ajax/withdraw',
                                        'enableAjaxValidation' => true,
                                        'options' => ['class' => 'card'],
                                    ]) ?>
                                    <div class="card-body">
                                        <h5 class="card-title"><?=\Yii::t('main', 'Withdraw money');?></h5>
                                        <div class="card-text">
                                            <div class="row">
                                                <span class="col-md-3">
                                                    <?=$form->field($data['withdrawModel'], 'funds', ['enableAjaxValidation' => true])
                                                        ->textInput(['id'=>'withdraw_process_val', 'class'=>'form-control', 'maxlength' => 8])
                                                        ->label(false);?>
                                                    <p class="sub-text">
                                                        <?=\Yii::t('main', 'How much you want to withdraw?');?>
                                                    </p>
                                                </span>
                                                <span class="col-md-6">
                                                    <?=$form->field($data['withdrawModel'], 'bill', ['enableAjaxValidation' => true])
                                                        ->textInput(['class'=>'form-control', 'maxlength' => 180])
                                                        ->label(false);?>
                                                    <p class="sub-text">
                                                        <?=\Yii::t('main', 'Enter your {types} number', ['types'=>implode(' or ',['Visa','PayPall'])]);?>
                                                    </p>
                                                </span>
                                                <span class="col-md-3">
                                                    <?= Html::submitButton(Yii::t('main', 'Submit'), [
                                                            'class' => 'btn btn-secondary',
                                                            'id'=>'withdraw_process'
                                                    ]) ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php ActiveForm::end() ?>
                            </div>
                        </div>
                        <div class="panel panel-default transaction__list">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" style="min-width:40%"><?=\Yii::t('main', 'Comment');?></th>
                                        <th scope="col"><?=\Yii::t('main', 'Value');?></th>
                                        <th scope="col"><?=\Yii::t('main', 'Date');?></th>
                                        <th scope="col"><?=\Yii::t('main', 'Transaction');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(count($data['transactions']) > 0) {
                                        foreach($data['transactions'] as $t) {?>
                                            <tr <?php
                                                if($t->status==1) echo 'class="bg-secondary"';
                                                elseif($t->status==2) echo 'class="bg-info"';
                                                elseif($t->status==3) echo 'class="bg-success"';
                                                elseif($t->status==4||$t->status==5)  echo 'class="bg-danger"';
                                            ?>>
                                                <td><?=$t->operation;?></td>
                                                <td><?=round($t->value,2)?>$</td>
                                                <td>
                                                    <?=Yii::$app->formatter->asDatetime($t->create_date, 'php:d F Y H:m')?>
                                                </td>
                                                <td class="text-center"><?=$t->statusName->getTitle();?></td>
                                            </tr><?php
                                        }
                                    } else {?>
                                        <tr><td colspan="3"><?=\Yii::t('main', 'You have no transactions');?></td> </tr>
                                        <?php
                                    }?>
                                </tbody>
                            </table>
                        </div>
						
                        <div class="panel panel-default transaction__list" id="codeCreated">
							<div class="panel-heading">
								<h3 class="panel-title"><?=\Yii::t('main', 'Your invite code');?></h3>
							</div>
							<div class="panel-body">
								<?php if($data['user']['invite']) { ?>
									<div class="row copyGroup">
										<div class="col-md-8"><input class="form-control text-center" type="text" value="<?=$data['user']['invite']?>" disabled></div>
										<div class="col-md-4 inputtooltip">
											<button class="btn btn-success btn-small btn-sm form-control text-center copy-action">
												<span class="tooltiptext" id="myTooltip"><?=\Yii::t('main', 'Copy to clipboard');?></span>
												<?=\Yii::t('main', 'Copy');?>
											</button>
										</div>
									</div>
								<?php } else { ?>
									<button class="btn btn-success btn-small btn-sm form-control text-center invite-code-create" ><?=\Yii::t('main', 'Create invite code');?></button>
								<?php } ?>
							</div>
						</div>
						
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title"><?=\Yii::t('main', 'Your friends');?></h3>
							</div>
							<div class="panel-body">
								<table class="table">
									<thead>
										<tr>
											<td><?=\Yii::t('main', 'Id');?></td>
											<td><?=\Yii::t('main', 'User Name');?></td>
											<td><?=\Yii::t('main', 'User Email');?></td>
											<td><?=\Yii::t('main', 'Registration Date');?></td>
											<td class="text-center"><?=\Yii::t('main', 'Your Income ($)');?></td>
										</tr>
									</thead>
								<?php if ($data['friends']) { ?>
									<?php foreach($data['friends'] as $friend) { ?>
										<tr>
											<td><?=$friend->id?></td>
											<td><?=$friend->username?></td>
											<td><?=$friend->email?></td>
											<td><?php 
												if($friend->created_at) {
													echo Yii::$app->formatter->asDate($friend->created_at, 'dd.MM.YY HH:mm');
												} else {
													echo Yii::t('main', 'Registration not finished');
												}
												?>
											</td>
											<td class="text-center">
												<span class="label label-success">0$</span>
											</td>
										</tr>
									<?php } ?>
								<?php } else { ?>
									<tr><td colspan="5" class="text-center"><?=\Yii::t('main', 'No user invited');?></td></tr>
								<?php }?>
								</table>
							</div>
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
                                <li class="active"><a href="<?=Url::to(['/user/billing'])?>">Billing</a></li>
                                <li><a href="<?=Url::to(['/user/reviews'])?>">Reviews</a></li>
                                <li class="user-logout special" onclick="logout()"><a href="/user/settings/#">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php //$this->registerJs("");?>
<?=$this->render('/site/content/footer', compact('menu')); ?>