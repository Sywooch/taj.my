<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BillingProcess */

$this->title = Yii::t('app', 'Create Billing Process');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Billing Processes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="billing-process-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
