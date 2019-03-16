<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ReviewComment */

$this->title = Yii::t('app', 'Create Review Comment');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Review Comments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="review-comment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
