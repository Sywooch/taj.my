<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use dektrium\user\models\User;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Products');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Product'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
			[
				'label'		=> 'Image',
				'attribute' => 'image',
				'format' => 'html',    
				'value' => function ($data) {
					return Html::img(Yii::getAlias('@web').$data->image,
						['width' => '70px']);
				},
			],
			[
				'label' => 'Title',
				'format' => 'raw',
				'value' => function($data){
					return '
					<div>EN: <span class="label label-primary">'.$data->title_en.'</span></div>
					<div>AR: <span class="label label-primary">'.$data->title_ar.'</span></div>
					';
					
				},
			],
			[
				'label' => 'Page Reviews',
				'format' => 'html',    
				'value' => function($data){
					return '<span class="label label-info">'.$data->count_reviews.'</span>';
				}
			],
			[
				'label' => 'Rank',
				'format' => 'html',
				'value'	 => function($data) {
					if($data->avg_rank>0) {
						return '<span class="label label-success">'.$data->avg_rank.'</span>';
					} else {
						return '-';
					}
				}
			],
			[
				'label' => 'Reviews',
				'format' => 'html',
				'value'	 => function($data) {
					return '<span class="label label-success">'.$data->count_reviews.'</span>';
				}
			],
            'link',
			[
				'label' => 'Page Reviews',
				'format' => 'html',    
				'value' => function($data){
					return '<span class="label label-success">'.$data->count_reviews.'</span>';
				}
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
			[
			'label' => 'Show on site',
				'format' => 'raw',
				'value' => function($data){
					return  Html::a('Show on site','/product/'.$data['category']->link . '/'.$data->link, ['target'=>'_blank', 'data-pjax'=>"0"] );
				},
			],
            //'count_reviews',
            //'avg_rank',
            //'category_id',
            //'create_date',
			
			//'status',
            /*[
				'label' => 'Status',
				'format' => 'html',    
				'value' => function($data){
					if($data->status) {
						return '<span class="label label-success">ON</span>';
					} else {
						return '<span class="label label-danger">OFF</span>';
					}
				}
			],*/

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
