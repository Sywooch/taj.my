<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Reviews');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="review-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
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
				'label' => 'Author',
				'format' => 'html',    
				'value' => function($data){
					return 
					'<a href="/adminpanel/user/update?id='.$data->author->user_id.'">'.
					Html::img(Yii::getAlias('@web').$data->author->getAvatar(),
						['width' => '70px']).
					$data->author->name.
					'</a>';
				}
			],
			[
				'label' => 'Product',
				'format' => 'html',    
				'value' => function($data){
					if($data->product)
						return 
						'<a href="/adminpanel/product/update?id='.$data->product->id.'">'.
						Html::img(Yii::getAlias('@web').$data->product->getProductImage(),
							['width' => '70px']).
						$data->product->title_en.
						'</a>';
					else 
						return '<span class="btn btn-danger">PRODUCT WAS DELETED</span>';
				}
			],
            'cost',
			[
				'label' => 'Url',
				'format' => 'raw',    
				'value' => function($data){
					return 
					'<a onclick="window.open(\'/review/'.$data->product->link.'/'.$data->link.'\')"  target="_blank">'.
					$data->link.
					'</a>';
				}
			],
            //'use_exp',
            //'rank',
			[
				'label' => 'Likes',
				'format' => 'html',    
				'value' => function($data){
					return '('.$data->likes.')';
				}
			],
            //'recommend_status',
            //'create_date',
            //'link',
            'views',
			[
				'label' => 'Product',
				'format' => 'html',    
				'value' => function($data){
					if($data->publish==1) {
						return '<span class="btn btn-success">Published</span>';
					} elseif($data->publish==2) {
						return '<span class="btn btn-warning">Canceled</span>';
					}elseif($data->publish==3) {
						return '<span class="btn btn-primary">Removed</span>';
					}elseif($data->publish==0) {
						return '<span class="btn btn-danger">On moderation</span>';
					}
				}
			],
			
			[
			'label' => 'Show on site',
				'format' => 'raw',
				'value' => function($data){
					return  Html::a('Show on site','/review/'.$data['product']->link . '/'.$data->link, ['target'=>'_blank', 'data-pjax'=>"0"] );
				},
			],
            //'publish',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
