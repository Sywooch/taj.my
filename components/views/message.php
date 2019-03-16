<?php
/**
 * Created by PhpStorm.
 * User: villa
 * Date: 28.11.2018
 * Time: 1:19
 */
use yii\bootstrap\Html;
use yii\widgets\ActiveForm;

$formSend = false;
?>
	<?php if (Yii::$app->session->hasFlash('success')): ?>
		<div class="alert alert-success alert-dismissable">
			 <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			 <h4><i class="icon fa fa-check"></i> <?=Yii::t('app', 'Your message has been send')?></h4>
		</div>
		<?php $formSend = true; ?>
	<?php endif; ?>

	<?php if (Yii::$app->session->hasFlash('error')): ?>
		<div class="alert alert-danger alert-dismissable">
			 <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			 <h4><i class="icon fa fa-check"></i><?=Yii::t('app', 'There was some errors while sending your message. Please, try one more time.')?></h4>
		</div>
	<?php endif; ?>
	
	<?php if(!$formSend) : ?>
    <?php $form = ActiveForm::begin(['action' => ['upload/message']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'reCaptcha')->widget(\himiklab\yii2\recaptcha\ReCaptcha::className())->label(''); ?>
	
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Send Message'), ['class' => 'btn btn-success pull-right']) ?>
    </div>
    <?php ActiveForm::end(); ?>
	<?php endif; ?>
	