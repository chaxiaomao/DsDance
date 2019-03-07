<?php

namespace backend\modules\WorkSpace\modules\Student\controllers;

use common\models\c2\entity\UserCardRsModel;
use Yii;
use common\models\c2\entity\FeUserModel;
use common\models\c2\search\FeUserSearch;

use cza\base\components\controllers\backend\ModelController as Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for FeUserModel model.
 */
class DefaultController extends Controller
{
    public $modelClass = 'common\models\c2\entity\FeUserModel';
    
    /**
     * Lists all FeUserModel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FeUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $this->retrieveModel(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FeUserModel model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * create/update a FeUserModel model.
     * fit to pajax call
     * @return mixed
     */
    public function actionEdit($id = null) 
    {
        $model = $this->retrieveModel($id);
        
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash($model->getMessageName(), [Yii::t('app.c2', 'Saved successful.')]);
            } else {
                Yii::$app->session->setFlash($model->getMessageName(), $model->errors);
            }
        }
        
        return (Yii::$app->request->isAjax) ? $this->renderAjax('edit', [ 'model' => $model,]) : $this->render('edit', [ 'model' => $model,]);
    }
    
    /**
     * Finds the FeUserModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return FeUserModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FeUserModel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAddCard() {
        $this->layout = '/empty';
        $model = new UserCardRsModel();
        $id = null;
        if (Yii::$app->request->isPost) {
            $id = Yii::$app->request->post(basename(get_class($model)))['user_id'];
        } else {
            $id = Yii::$app->request->get('user_id');
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash($model->getMessageName(), [Yii::t('app.c2', 'Saved successful.')]);
            } else {
                Yii::$app->session->setFlash($model->getMessageName(), $model->errors);
            }
        }
        return $this->render('add_card_form', [
            'model' => $model,
            'user_id' => $id,
        ]);
    }

}
