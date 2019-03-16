<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Information */
/* @var $form yii\widgets\ActiveForm */
?>

	<div class="information-form">

		<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'id')->hiddenInput()->label('') ?>

		<?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>
		
		<div class="form-group">
			<?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
		</div>

		<?php ActiveForm::end(); ?>

	</div>
	<div class="row">
		<h2 class="text-center">Save current page to edit content</h2>
	</div>
</div>
