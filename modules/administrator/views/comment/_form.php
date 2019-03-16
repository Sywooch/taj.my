<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\User;
use app\models\Review;
use mihaildev\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\models\ReviewComment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="review-comment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->hiddenInput()->label('') ?>

	<?= $form->field($model, 'review_id')->dropDownList(
      ArrayHelper::map(Review::find()->all(), 'id', 'title_en')
	  ); 
	?>
	
	<?= $form->field($model, 'user_id')->dropDownList(
	  ArrayHelper::map(User::find()->all(), 'id', 'username')
	  ); 
	?>
	<div class="row">
		<div class="col-md-6">
			<?= $form->field($model->reviewCommentContent[0], 'id',[
				'inputOptions' => [	
						'name'=>'ReviewCommentContent[0][id]',
					]
			])->hiddenInput()->label('') ?>
			<?= $form->field($model->reviewCommentContent[0], 'content',[
				'inputOptions' => [	
						'name'=>'ReviewCommentContent[0][content]',
					]
			])->widget(CKEditor::className(),[ 'options'=>['rows'=>30,'id'=>'informationcontent_0','name'=>'ReviewCommentContent[0][content]',]]); ?>
			<?= $form->field($model->reviewCommentContent[0], 'lang',[
				'inputOptions' => [	
						'name'=>'ReviewCommentContent[0][lang]',
					]
			])->textInput() ?>
		</div>
		<div class="col-md-6">
			<?= $form->field($model->reviewCommentContent[1], 'id',[
				'inputOptions' => [	
						'name'	=>'ReviewCommentContent[1][id]',
					]
			])->hiddenInput()->label('') ?>
			<?= $form->field($model->reviewCommentContent[1], 'content',[
				'inputOptions' => 
					[	
						'id'	=>'content'.$model->reviewCommentContent[1]['lang'],
						'name'	=>'ReviewCommentContent[1][content]',
					]
					
				])->widget(CKEditor::className(),['options'=>['rows'=>30,'id'=>'informationcontent_1','name'=>'ReviewCommentContent[1][content]',]]); ?>
			<?= $form->field($model->reviewCommentContent[1], 'lang',[
				'inputOptions' => [	
						'name'=>'ReviewCommentContent[1][lang]',
					]
			])->textInput() ?>
		</div>
	</div>

    <?= $form->field($model, 'create_date')->textInput() ?>

	<?= $form->field($model, 'status')->dropDownList(
		[
			'0' => 'Moderation',
			'1' => 'Published',
		]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
