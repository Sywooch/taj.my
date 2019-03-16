<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

	
<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput([ 'disabled' => 'true']) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
	
	<?= Html::label('Password (Set blank if no need to change)', 'password') ?>
	<?= Html::passwordInput('password', '', ['class' => 'form-control']) ?>


    <?= $form->field($model, 'unconfirmed_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'blocked_at')->dropDownList(
		[
			'' => 'Active',
			'1' => 'Blocked',
		]);?>

	<div class="hidden">
		<?= $form->field($model, 'password_hash')->hiddenInput()->label('') ?>
		<?= $form->field($model, 'registration_ip')->textInput(['maxlength' => true]) ?>
		<?= $form->field($model, 'created_at')->textInput() ?>
		<?= $form->field($model, 'updated_at')->textInput() ?>
		<?= $form->field($model, 'flags')->textInput() ?>
		<?= $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?>
		<?= $form->field($model, 'confirmed_at')->textInput() ?>
		<?= $form->field($model, 'last_login_at')->textInput() ?>
	</div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
	
	<hr>
	<?php if($change) { ?>
		<h2>Moderate History</h2>
		<table class="table">
			<thead>
				<tr>
					<td>Review ID</td>
					<td>User</td>
					<td>Review Title</td>
					<td>Views</td>
					<td>Income ($)</td>
					<td>Date</td>
				
				</tr>
			</thead>
		<?php foreach($change as $c) { ?>
			<tr>
				<td>
					<?=$c->review->id;?>
				</td>
				<td>
					<a href="/adminpanel/user/update?id=<?=$c->review->user_id?>">
						<?= Html::img($c->review->getAuthorAvatar(), ['width' => '50']) ?>
						<?=$c->review->getAuthorName()?>
					</a>
					(ID: <?=$c->review->user_id?>)
				</td>
				<td>
					<a href="/adminpanel/review/update?id=<?=$c->id?>">
						<?= Html::img('/'.$c->review->getImage(), ['width' => '50']) ?>
						<?=$c->review->title_en?>
					</a>
				</td>
				<td>
					<?=$c->review->views?>
				</td>
				<td>
					<?=$c->review->getReviewsIncome()?>
				</td>
				<td><?=$c->date?></td>
			</tr>
		<?php } ?>	
		</table>
	<?php } ?>
</div>
