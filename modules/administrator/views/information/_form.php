<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;


/* @var $this yii\web\View */
/* @var $model app\models\Information */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="information-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>
	
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<div class="row">
	<div class="col-md-6">
		<?php $form2 = ActiveForm::begin(); ?>
		<?= $form2->field($content['en'], 'information_id')->hiddenInput()->label(''); ?>
		<?= $form2->field($content['en'], 'lang')->hiddenInput()->label('') ?>
		<h2>
			English
		</h2>
		<?= $form2->field($content['en'], 'title')->textInput(['maxlength' => true]) ?>
		<?= $form->field($content['en'], 'content')->widget(CKEditor::className(),['editorOptions' => ['height'=>'400px'],]); ?>
		
		<div class="form-group">
			<?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
		</div>
		<?php ActiveForm::end(); ?>
	</div><div class="col-md-6">
		<?php $form2 = ActiveForm::begin(); ?>
		<?= $form2->field($content['ar'], 'information_id')->hiddenInput()->label(''); ?>
		<?= $form2->field($content['ar'], 'lang')->hiddenInput()->label('') ?>
		<h2>
			Arabic
		</h2>
		<?= $form2->field($content['ar'], 'title')->textInput(['maxlength' => true]) ?>
		<?= $form->field($content['ar'], 'content')->widget(CKEditor::className(),[ 'options'=>['rows'=>30,'id'=>'informationcontent_ar'],'editorOptions' => ['height'=>'400px']]); ?>
		<div class="form-group">
			<?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
		</div>
		<?php ActiveForm::end(); ?>
	</div></div>
</div>
