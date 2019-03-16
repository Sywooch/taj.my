<?php

namespace app\modules\administrator\controllers;

use function var_export;
use Yii;
use app\models\ReviewComment;
use app\models\Review;
use app\models\ReviewCommentContent;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CommentController implements the CRUD actions for ReviewComment model.
 */
class CommentController extends Controller
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
        ];
    }

    /**
     * Lists all ReviewComment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ReviewComment::find()->alias('comment')->orderBy(['comment.status' => SORT_ASC])->joinWith('author')->joinWith('review')->joinWith('reviewCommentContent'),
        ]);
//        $test = new Review();
//        $test2 = $test::find()->all();
//        var_export($test2);die;

//        $test = new ActiveDataProvider([
//            'query' => ReviewComment::find()->alias('comment')->joinWith("review")
//        ]);
//        echo '<pre>';
//        var_export($dataProvider->models);
//        echo '</pre>';die;
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ReviewComment model.
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
     * Creates a new ReviewComment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ReviewComment();
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			foreach(Yii::$app->request->post('ReviewCommentContent') as $post) {
				$content = new ReviewCommentContent();
				$content->load($post);
				$content->save();
			}
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => ReviewComment::find()->alias('comment')->joinWith('author')->joinWith('review')->joinWith('reviewCommentContent')->one(),
        ]);
    }

    /**
     * Updates an existing ReviewComment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
		if(Yii::$app->request->get('update_status')==1) {
			$model = $this->findModel($id);
			$model->status = Yii::$app->request->get('status');
			$model->save(false);
			$result['result'] = true;
			
			return json_encode($result);
		}
		
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			foreach(Yii::$app->request->post('ReviewCommentContent') as $post) {
				if($post['id']>0) {
					$content = ReviewCommentContent::find()->where(['id'=>$post['id']])->one();
					$content->content 	= $post['content'];
					$content->lang 		= $post['lang'];
					$content->update(false);
				} else {
					$content = new ReviewCommentContent();
					$content->id 		= $post['id'];
					$content->content 	= $post['content'];
					$content->lang 		= $post['lang'];
					
					$content->save(false);
				}
			}
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $this->findModelWithContent($id),
        ]);
    }
    /**
     * Deletes an existing ReviewComment model.
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
     * Finds the ReviewComment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ReviewComment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ReviewComment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    protected function findModelWithContent($id)
    {
        if (($model = ReviewComment::find($id)->joinWith('reviewCommentContent')->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
