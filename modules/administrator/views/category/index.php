<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Category;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Category'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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
				'label' => 'Parent Category',
				'format' => 'raw',
				'value' => function($data) {
					if($data->parent_id>0) {
						$parent = Category::find()->where(['id'=>$data->parent_id])->one();
//						$test=  $parent->getName();
//                        echo '<pre>';
//						return var_export($data->title_en.get_class_methods($parent));
						return '<a href="/adminpanel/category/update?id='.$data->parent_id.'">'.$parent->getName().' <b>(ID:'.$data->parent_id.')</b></a>';
					} else {
						return '<span class="label label-success">Main</span>';
					}
				}
			],
            'link',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
