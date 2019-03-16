<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Support */

$this->title = Yii::t('app', 'Update Support: {name}', [
    'name' => $model->title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Supports'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="support-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
