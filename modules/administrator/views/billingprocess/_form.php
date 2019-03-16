<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\User;
use mihaildev\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\models\BillingProcess */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="billing-process-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

	<?= $form->field($model, 'user_id')->dropDownList(
      ArrayHelper::map(User::find()->all(), 'id', 'username')
	  ); 
	?>
	  
	<?= $form->field($model, 'operation')->widget(CKEditor::className(),['editorOptions' => [],]); ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(
		[
			'1' => 'Moderation',
			'2' => 'In Process',
			'3' => 'Completed',
			'4' => 'Canceled by user',
			'5' => 'Canceled by administrator',
		]) ?>

    <?= $form->field($model, 'create_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
