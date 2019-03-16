<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
$formatter = \Yii::$app->formatter;

?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

	<div>
		<a href="/adminpanel/user" class="btn btn-sm btn-default">All Users</a>
	<?php
		$roles = (Yii::$app->authManager->getRoles());
		foreach($roles as $role) {
			echo '<a href="/adminpanel/user?role='.$role->name.'" class="btn btn-sm btn-primary">'.
			$role->description.'
			</a>';
		}
	?>
		<form method="GET" class="pull-right">
			<input name="name" placeholder="Search User">
		</form>
	</div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\ActionColumn'],

            'id',
            'username',
			[
				'label' => 'Balance ($)',
				'format' => 'raw', 
				'value' => function($data) {
					if($data->billing->value)
						return $data->billing->value;
					else return '<span style="color:#ccc">0</span>';
				}
			],
            'email:email',
            //'confirmed_at',
            //'unconfirmed_email:email',
            //'blocked_at',
            //'updated_at',
            //'flags',
			[
				'label' => 'Registration',
				'format' => 'raw',
				'value' => function($data){
					if($data->created_at>0) 
						return '<span class="label label-primary">'.Yii::$app->formatter->asDate($data->created_at, 'dd.MM.YY H:m').'</span>';
					else {
						return '<span class="label label-default">No info</span>';
					}
				},
			],
			[
				'label' => 'Last Login',
				'format' => 'raw',
				'value' => function($data){
					if($data->last_login_at>0) 
						return '<span class="label label-primary">'.Yii::$app->formatter->asDate($data->last_login_at, 'dd.MM.YY H:m').'</span>';
					else {
						return '<span class="label label-default">No info</span>';
					}
				},
			],
			[
				'label' => 'Role',
				'format' => 'raw', 
				'value' => function($data) {
						$roles = Yii::$app->authManager->getRolesByUser($data->id);
						$return = '';
						foreach($roles as $role) {
							$return.= '<a href="/adminpanel/user?role='.$role->name.'" class="btn btn-sm btn-default">'.$role->description."</a>";
						}
						
					return $return;
				}
			],
            'registration_ip',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
