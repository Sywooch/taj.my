<?php

namespace app\modules\administrator;

use Yii;
use yii\filters\AccessControl;
use common\components\rbac\UserRoleRule;
use models\User;
use \app\models\support;
use \app\models\reviewComment;

/**
 * adminpanel module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\administrator\controllers';

    /**
     * {@inheritdoc}
     */
	 
	public function behaviors() {
		
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'roles' => ['admin','moderator'],
					]
				],
			],
		];
	}
	
	public function init()

	{
		\Yii::$app->view->theme = new \yii\base\Theme([

			'pathMap' => ['@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'],

		]);
		
		$message = \app\models\Support::find()->where(['status'=>0])->count();
		$comments = \app\models\ReviewComment::find()->where(['status'=>0])->count();

		parent::init();

	}
	
	public static function getUserList()
	{
		$parents = User::find()
			->select(['id', 'username'])
			->distinct(true)
			->all();

		return ArrayHelper::map($parents, 'id', 'name');
	}
}
