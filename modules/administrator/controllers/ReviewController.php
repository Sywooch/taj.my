<?php

namespace app\modules\administrator\controllers;

use Yii;
use app\models\Review;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
/**
 * ReviewController implements the CRUD actions for Review model.
 */
class ReviewController extends Controller
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
					'update' => ['get', 'put', 'post','ajax'],
                ],
            ],
        ];
    }

    /**
     * Lists all Review models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Review::find()->joinWith('author')->joinWith('product')->orderBy(['create_date'=> SORT_DESC]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Review model.
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
     * Creates a new Review model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Review();
//
//        echo "<pre>";
//        var_export($model);die;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Review model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
//        echo "<pre>";
//        var_export($model);die;
		if(Yii::$app->request->get('setstatus')>0) {
			$model->publish = Yii::$app->request->get('setstatus');
			if($model->save())
            return $this->redirect(Yii::$app->request->get('return'));
		}
		
		
        if ($model->load(Yii::$app->request->post()) ) {
			if($model->img_main == '') {
				$model->img_main = NULL;
			}
			
			if($model->save(false))
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Review model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
		
		$comments = (new \yii\db\Query())
			->from('yy_review_comment')
			->where(['review_id'=>$id])->all();
		
		foreach($comments as $comment) {
			(new Query)
				->createCommand()
				->delete('yy_review_comment_likes', ['comment_id' => $comment->id])
				->execute();
		}
		(new Query)
			->createCommand()
			->delete('yy_reviews_content', ['review_id' => $id])
			->execute();
		(new Query)
			->createCommand()
			->delete('yy_reviews_subimage', ['review_id' => $id])
			->execute();
		(new Query)
			->createCommand()
			->delete('yy_review_likes', ['review_id' => $id])
			->execute();
		(new Query)
			->createCommand()
			->delete('cc_review_changes', ['review_id' => $id])
			->execute();
		
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Review model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Review the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Review::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
