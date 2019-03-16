<?php

namespace app\modules\administrator\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\Information;
use app\models\InformationContent;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InformationController implements the CRUD actions for Information model.
 */
class InformationController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'roles' => ['admin'],
					]
				],
			],
        ];
    }

    /**
     * Lists all Information models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Information::find()->joinWith('content'),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Information model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
			'content'	=> [
				'en' => $this->findContent($id, 'en'),
				'ar' => $this->findContent($id, 'ar'),
			],
        ]);
    }

    /**
     * Creates a new Information model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
	
		$model = new Information();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			
			foreach(array('en','ar') as $lang) {
				$content = new InformationContent();
				$content->information_id 	= $model->id;
				$content->lang 				= $lang;
				$content->save();
			}
			
			return $this->redirect(['update', 'id' => $model->id]);
		}
		
		return $this->render('create', [
			'model' => $model,
			'content' => $content,
		]);
    }

    /**
     * Updates an existing Information model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
		
		$content['en'] = $this->findContent($id, 'en');
		$content['ar'] = $this->findContent($id, 'ar');
		
		
		
        $model = $this->findModel($id);
		
		if(Yii::$app->request->post('InformationContent')) {
			$content = $this->findContent($id,Yii::$app->request->post('InformationContent')['lang']);
			if ($content->load(Yii::$app->request->post()) && $content->save()) {
				return $this->redirect(['update', 'id' => $model->id]);
			}
		
		} elseif ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        }
		
        return $this->render('update', [
            'model' => $model,
			'content'	=> $content,
        ]);
    }

    /**
     * Deletes an existing Information model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
		$this->findContent($id,'en')->delete();
		$this->findContent($id,'ar')->delete();
		
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Information model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Information the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Information::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
	
	protected function findContent($id, $lang = 'en')
    {
        if ($model = InformationContent::find()->where(['information_id'=>$id, 'lang'=>$lang])->one()) {
            return $model;
        } else { return new InformationContent(); }
    }
}
