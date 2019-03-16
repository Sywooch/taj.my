<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Billing */

$this->title = Yii::t('app', 'Update Billing: {name}', [
    'name' => $model->user_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Billings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user_id, 'url' => ['view', 'id' => $model->user_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="billing-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
