<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Billings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="billing-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Billing'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
				'label'		=> 'User',
				'attribute' => 'html',
				'format' => 'html',    
				'value' => function ($data) {
					return $data->user->name. "<b> (ID: ".$data->user_id.")</b>";
				},
			],
			[
				'label'		=> 'Amount',
				'attribute' => 'html',
				'format' => 'html',    
				'value' => function ($data) {
					return round($data->value,2);
				},
			],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
