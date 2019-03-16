<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = Yii::t('app', 'Update User: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="user-update">
	<div class="row">
		<div class="col-md-6"><h1 style="margin:0"><?= Html::encode($model->username) ?></h1></div>

	<div class="roles col-md-6 text-right">
		Roles:
		<?php 
			$roles = Yii::$app->authManager->getRolesByUser($model->id);
			foreach($roles as $role) {
				$r[$role->name] = true;
			}
			
			foreach (Yii::$app->authManager->getRoles() as $role) {
				if(isset($r[$role->name])) {
					echo '
					<a class="btn btn-sm btn-danger" href="/adminpanel/user/removerole?id='.$model->id.'&role='.$role->name.'" title="Remove Role">'.$role->description."( Click to Delete )</a>
					";
				} else {
					echo '
					<a class="btn btn-sm btn-success" href="/adminpanel/user/addrole?id='.$model->id.'&role='.$role->name.'" title="Remove Role">'.$role->description." ( Click to Add )</a>";
				}
			}
			
		?>
	</div>
	</div>
    <?= $this->render('_form', [
        'model' => $model,
        'change' => $change,
    ]) ?>

</div>
