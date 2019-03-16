<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Profiles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Profile'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'user_id',
            'name',
            'public_email:email',
            'location',
			[
				'label' => 'Website',
				'format' => 'raw', 
				'value' => function($data) {
					return Html::a($data->website,$data->website);
				}
			],
			[
				'label' => 'Role',
				'format' => 'raw', 
				'value' => function($data) {
						$roles = Yii::$app->authManager->getRolesByUser($data->user_id);
						$return = '';
						foreach($roles as $role) {
							$return.= '<span class="btn btn-sm btn-default">'.$role->description."</span>";
						}
						
					return $return;
				}
			],
            //'bio:ntext',
            //'avatar',
            //'timezone',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
