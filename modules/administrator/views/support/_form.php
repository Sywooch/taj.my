<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Support */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="support-form">

    <?php $form = ActiveForm::begin(); ?>

	<?php if($model->warning==1) { ?>
		<h2 class="form-group">
			<a target="_blank" href="<?=substr($model->title,11);?>" title="">Open reported page</a>
		</h2>
		<div class="hidden">
			<?= $form->field($model, 'title')->hiddenInput()->label('') ?>
		</div>
	<?php } else { ?>
	
		<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
	
	<?php } ?>
    <?= $form->field($model, 'status')->dropDownList(
		[
			'0' => 'New',
			'1' => 'In Process',
			'2' => 'Closed',
			'3' => 'Spam',
		]); ?>
    <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
	
    <?= $form->field($model, 'create_date')->textInput(['maxlength' => true]) ?>
	

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
