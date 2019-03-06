<?php

namespace backend\modules\WorkSpace\modules\Config\controllers;

use Yii;
use common\models\c2\entity\CourseModel;
use common\models\c2\search\CourseSearch;

use cza\base\components\controllers\backend\ModelController as Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for CourseModel model.
 */
class DefaultController extends Controller
{
    public $modelClass = 'common\models\c2\entity\CourseModel';
    
    /**
     * Lists all CourseModel models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->request->isPost) {
            $expired_time = Yii::$app->request->post()['BusinessConfigForm']['expired_time'];
            $notice = Yii::$app->request->post()['BusinessConfigForm']['notice'];
            $cache = Yii::$app->cache;
            $cache->set('expired_time', $expired_time);
            $cache->set('notice', $notice);
            Yii::$app->session->setFlash('business-config-form-message', [Yii::t('app.c2', 'Saved successful.')]);
        }
        return $this->render('index', [
        ]);
    }

}
