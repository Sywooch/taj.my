<?php

namespace app\modules\administrator\controllers;

use Yii;
use app\models\User;
use app\models\Review;
use app\modules\administrator\models\Adminchanges;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
	
    public function behaviors()
    {
        return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
				
					[
						'actions' => ['index','create','view'],
						'allow' => true,
						'roles' => ['admin'],
					],
					[
						'actions' => ['removerole','update','addrole'],
						'allow' => true,
						'roles' => ['admin'],
					],
				],
			],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */ 
    public function actionIndex($role = '',$name = '')
    {
		
		if(!$role&&!$name) {
			$dataProvider = new ActiveDataProvider([
				'query' => User::find()->joinWith('billing'),
			]);
		} elseif($name) {
			$dataProvider = new ActiveDataProvider([
					'query' => User::find()->where(['like','username',$name])->joinWith('billing'),
			]);
		} else {
			$connection = \Yii::$app->db;
			$connection->open();

			$command = $connection->createCommand(
				"SELECT * FROM auth_assignment INNER JOIN user ON auth_assignment.user_id = user.id " .
				"WHERE auth_assignment.item_name = '" . $role . "';");

			$users = $command->queryAll();
			$connection->close();

			if($users) {
				$user_id = [];
				foreach($users as $user) {
					$user_id[] = $user;
				}
				$dataProvider = new ActiveDataProvider([
					'query' => User::find()->where(['id'=>$user_id])
				]);
			} else {
				
				$dataProvider = new ActiveDataProvider([
					'query' => User::find()->where(['id'=>0]),
				]);
			}
		}

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }
	
    public function actionRemoverole($id,$role)
    {
		if($id==4) {
			return 'Manipulate For Admin Account was Blocked';
		}
		$role = Yii::$app->authManager->getRole($role);
		Yii::$app->authManager->revoke($role,$id);
		
		return $this->redirect(['update', 'id' => $id]);
    }
    public function actionAddrole($id,$role)
    {
		if($id==4) {
			return 'Manipulate For Admin Account was Blocked';
		}
		$role = Yii::$app->authManager->getRole($role);
		Yii::$app->authManager->assign($role,$id);
        
		return $this->redirect(['update', 'id' => $id]);
		
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
		
        $model = $this->findModel($id);
		$changes = Adminchanges::find()->alias('c')->where(['c.user_id'=>$id])->orderBy(['c.date'=> SORT_DESC])->joinWith('review')->all();

		if(Yii::$app->request->post()) {
			if(Yii::$app->request->post('password')!='') {
				$password_hash=Yii::$app->getSecurity()->generatePasswordHash(Yii::$app->request->post('password'));
			} else {
				$password_hash = NULL;
			}
			
		
			if ($model->load(Yii::$app->request->post())) {
				
				if($password_hash) {
					$model->password_hash=$password_hash;
				}
				
				if($model->save()) {
					return $this->redirect(['view', 'id' => $model->id]);
				}
			}
		}
			

        return $this->render('update', [
            'model' => $model,
			'change'	=> $changes,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
