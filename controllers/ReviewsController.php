<?php
namespace app\controllers;
use Yii;
use app\models\Review;
use yii\web\Controller;
use app\models\Block;
use app\models\Menu;
use app\controllers\SiteController;

class ReviewsController extends Review
{

    public function actionIndex($link = null,$start = 0) {
        $reviews = SiteController::getReview(10,$start);
        $menu = Block::getMenu();
		$userRole = $this->getCheckActiveRole();
        return $this->render('main', compact(['link', 'reviews', 'menu','userRole']));
    }

    public function actionAddNew()
    {
        $menu = Block::getMenu();
        return $this->render('main', compact(['menu']));
    }

    public function actionCreate()
    {
        $model = new Credit();
        $modelReferences = [new CreditRefence()];
        $modelFiles = [new CreditFile()];

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());

            foreach (Yii::$app->requestPost($modelReferences[0]->formName())
                     as $i => $data
            ) {
                $newModel = new CreditReference();
                $newModel->load($data, '');
                $modelReferences[$i] = $newModel;
            }

            foreach (Yii::$app->requestPost($modelFiles[0]->formName())
                     as $i => $data
            ) {
                $newModel = new CreditFile();
                $newModel->load($data, '');
                $newModel->file = UploadedFile::getInstance($newModel, "[$i]file");
                $modelFiles[$i] = $newModel;
            }

            $transaction = Yii::$app->db->beginTransaction(
                Transaction::SERIALIZABLE
            );

            try {
                $valid = $model->validate();
                $valid = Model::validateMultiple($modelReferences, [
                        'name',
                        'last_name',
                        // other fields, make sure to NOT include credit_id since
                        // the record has not been created yet.
                    ]) && $valid;
                $valid =  Model::validateMultiple($modelFiles, [
                        'file',
                        // other fields, make sure to NOT include credit_id since
                        // the record has not been created yet.
                    ]) && $valid;

                if ($valid) {
                    // the model was validated, no need to validate it once more
                    $model->save(false);

                    foreach ($modelReferences as $newModel) {
                        $newModel->credit_id = $model->id;
                        $newModel->save(false);
                    }

                    foreach ($modelFiles as $newModel) {
                        $newModel->credit_id = $model->id;
                        $newModel->file->saveAs(Yii::getAlias(
                            '@webroot/uploads/' . $model->file->name
                        ));
                        $newModel->save(false);
                    }

                    $transaction->commit();
                    return $this->redirect(['credit/view', ['id' => $model->id]]);
                } else {
                    $transaction->rollBack();
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                throw new BadRequestHttpException($e->getMessage(), 0, $e);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelReferences' => $modelReferences,
            'modelFiles' => $modelFiles,

        ]);
    }

    public function getReview($limit=5,$page=0) {
		if($this->getCheckActiveRole()) {
			$r = Review::find()
				->alias('review')
				->joinWith('product')
				->joinWith('reviewComment')
				->joinWith('reviewContentFirst')
				->joinWith('author')
				->groupBy('review.id')
				->orderBy(['review.create_date'=> SORT_DESC])
				->limit($limit)
				->offset($page*$limit)
				->all();
		} else {
			$r = Review::find()
				->alias('review')
				->joinWith('product')
				->joinWith('reviewComment')
				->joinWith('reviewContentFirst')
				->joinWith('author')
				->groupBy('review.id')
				->orderBy(['review.create_date'=> SORT_DESC])
				->where(['review.publish'=>1])
				->orWhere(['review.user_id'=>\Yii::$app->user->identity->id])
				->limit($limit)
				->offset($page*$limit)
				->all();
		}
			
        return $r;
    }

    public function getReviewCount()
    {
        return Review::find()
            ->alias('review')
            ->joinWith('product')
            ->groupBy('review.id')
            ->where(['review.publish' => 1])
			->orWhere(['review.user_id'=>\Yii::$app->user->identity->id])
            ->count();
    }
	
	
	public function getCheckActiveRole() {
		$roles = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->id);
		
		foreach($roles as $role) {
			if($role->name=='admin'||$role->name=='moderator') {
				return true;
			}
		}	
		
		return false;
	}
}