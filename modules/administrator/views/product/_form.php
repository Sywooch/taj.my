<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\User;
use app\models\Category;
use mihaildev\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'title_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title_ar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'description')->widget(CKEditor::className(),['editorOptions' => [],]); ?>
	
    <?= $form->field($model, 'image')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'count_reviews')->textInput() ?>

    <?= $form->field($model, 'avg_rank')->textInput() ?>

    <?= $form->field($model, 'category_id')->dropDownList(
      ArrayHelper::map(Category::find()->all(), 'id', 'title_en')
	  ); ?>

    <?= $form->field($model, 'create_date')->textInput() ?>

	<?= $form->field($model, 'created_by_user')->dropDownList(
      ArrayHelper::map(User::find()->all(), 'id', 'username')
	  ); 
	?>
	
	<?= $form->field($model, 'status')->dropDownList(
		[
			'1' => 'Published',
			'2' => 'In Moderation',
		]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
