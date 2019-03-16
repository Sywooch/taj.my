<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\StringHelper;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Supports');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="support-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Support'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

			[
				'label' => 'Status',
				'format' => 'html',
				'value' => function($data){
					switch($data->status) {
						case 0: return '<span class="label label-danger">New</span>';
						case 1: return '<span class="label label-warning">In Process</span>';
						case 2: return '<span class="label label-success">Closed</span>';
						case 3: return '<span class="label label-default">Spam</span>';
					}
					
				},
			],
			[
				'label' => 'Title',
				'format' => 'html',
				'value' => function($data){
					switch($data->warning) {
						case 0: return '<span class="label label-primary">'.$data->title.'</span>';
						case 1: return '<span class="target_blank label label-warning">'.\yii\helpers\StringHelper::truncate($data->title,45).'</span> '.Html::a('Open Report Page',str_replace('Report to: ','',$data->title), ['target' => '_blank','class'=>'label label-warning', 'data-pjax'=>"0"] );
						
					}
					
				},
			],
            'name',
            'email:email',
            'create_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
