<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Billing Processes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="billing-process-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Billing Process'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
				'label' => 'User',
				'format' => 'raw',
				'value' => function($data){
					return '<a href="/adminpanel/user/update?id='.$data->user->user_id.'" class="label label-default">'.$data->user->name.' (ID: '.$data->user->user_id.'</a>';
				},
			],
            'operation',
            'value',
			[
				'label'		=> 'User Billing (current)',
				'attribute' => 'html',
				'format' => 'html',    
				'value' => function ($data) {
					if($data->billing) {
						$r = '<span class="label label-success">'.round($data->remainder+$data->value,2).'</span> - <span class="label label-primary">'.$data->value.'</span> = ';
						if($data->billing->value - $data->value > 0) {
							$r .='<span class="label label-success">'.($data->remainder).'</span>';
						} else {
							$r .='<span class="label label-danger">'.($data->remainder).'</span>';
						}
						
						return $r;
					} else return 'No Billing';
				},
			],
			[
				'label' => 'Status',
				'format' => 'raw',
				'value' => function($data){
					switch($data->status) {
						case 1: return '<span class="label label-success">Moderation</span>';
						case 2: return '<span class="label label-primary">In Process</span>';
						case 3: return '<span class="label label-primary">Completed</span>';
						case 4: return '<span class="label label-danger">Canceled by user</span>';
						case 5: return '<span class="label label-danger">Canceled by administrator</span>';
					}
				},
			],
			[
				'label' => 'Create Date',
				'format' => 'raw',
				'value' => function($data){
					if($data->create_date>0) 
						return '<span class="label label-primary">'.Yii::$app->formatter->asDate($data->create_date, 'dd.MM.YY H:m').'</span>';
					else {
						return '<span class="label label-default">No info</span>';
					}
				},
			],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
