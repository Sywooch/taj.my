<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Billing */

$this->title = Yii::t('app', 'Create Billing');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Billings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="billing-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
