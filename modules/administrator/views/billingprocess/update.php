<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BillingProcess */

$this->title = Yii::t('app', 'Update Billing Process: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Billing Processes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="billing-process-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
