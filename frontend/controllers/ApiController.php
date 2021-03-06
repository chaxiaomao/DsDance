<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/6
 * Time: 9:53
 */

namespace frontend\controllers;


use common\models\c2\entity\FeUserModel;
use common\models\c2\entity\UserBusinessModel;
use common\models\c2\entity\UserEntranceModel;
use common\models\c2\search\DailyCourseModel;
use cza\base\models\statics\EntityModelStatus;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class ApiController extends Controller
{

    public $enableCsrfValidation = false;

    public function actionDailyCourse()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $date = \Yii::$app->request->get('date');
        $uid = \Yii::$app->request->get('uid');
        $records = null;
        if ($uid) {
            $records = UserEntranceModel::find()->where(['user_id' => $uid])->all();
        }
        $models = \common\models\c2\entity\DailyCourseModel::find()
            ->where(['date' => $date, 'status' => EntityModelStatus::STATUS_ACTIVE])
            ->all();
        $data = [];
        foreach ($models as $model) {
            $params = [
                'id' => $model->id,
                'course' => $model->course->name,
                'time' => $model->time,
                'teacher' => $model->user->username,
                'remain' => $model->remain, // 已预约人数
                'is_entrance' => $model->remain == $model->entrance_count ? 2 : 0, // 2:满人 0未满
            ];
            if ($records) {
                foreach ($records as $record) {
                    if ($record->daily_course_id == $model->id) {
                        $params['is_entrance'] = 1; // 已预约
                    }
                }
            }
            array_push($data, $params);
        }
        return ['code' => '000', 'data' => $data];
    }

    public function actionCancel()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $daily_course_id = Yii::$app->request->post('daily_course_id');
        $user_id = Yii::$app->request->post('user_id');
        $record = UserEntranceModel::findOne(['user_id' => $user_id, 'daily_course_id' => $daily_course_id]);
        $transaction = Yii::$app->db->beginTransaction();
        if ($record->delete()) {
            $dailyCourse = DailyCourseModel::findOne(['id' => $daily_course_id]);
            $dailyCourse->remain -= 1;
            if ($dailyCourse->save()) {
                $business = UserBusinessModel::findOne(['user_id' => $user_id]);
                $business->remain += 1;
                if ($business->save()) {
                    $transaction->commit();
                    return ['code' => '000', 'data' => true, 'message' => '操作成功'];
                } else {
                    $transaction->rollBack();
                    return ['code' => '501', 'data' => false, 'message' => '操作失败'];
                }
            }
        }
    }

    public function actionSign()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $mobile = Yii::$app->request->post('mobile');
        $user = FeUserModel::findOne(['mobile_number' => $mobile, 'status' => EntityModelStatus::STATUS_ACTIVE]);
        if ($user) {
            return ['code' => '000', 'data' => ['id' => $user->id]];
        } else {
            return ['code' => '501', 'data' => false, 'message' => '该用户尚未登记'];
        }
    }

    public function actionEntrance()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $user_id = Yii::$app->request->post('user_id');
        if (is_null($user_id)) {
            return ['code' => '501', 'data' => false, 'message' => '请先验证手机号码'];
        }
        $user = FeUserModel::find()->where(['id' => $user_id, 'status' => EntityModelStatus::STATUS_ACTIVE])->one();
        if (!$user) {
            return ['code' => '501', 'data' => false, 'message' => '抱歉，用户不存在'];
        }
        $business = UserBusinessModel::findOne(['user_id' => $user_id]);
        if (date('y-m-d h:i:s') > $business->period) {
            return ['code' => '501', 'data' => false, 'message' => '抱歉，您的会员已到期'];
        }
        if ($business->remain == 0) {
            return ['code' => '501', 'data' => false, 'message' => '抱歉，您的预约次数不足'];
        }
        $daily_course_id = Yii::$app->request->post('daily_course_id');
        // $record = UserEntranceModel::findOne(['user_id' => $user_id, 'daily_course_id' => $daily_course_id]);
        // if ($record) {
        //     return ['code' => '501', 'data' => false, 'message' => '请勿重复报名'];
        // }
        $dailyCourseModel = DailyCourseModel::findOne(['id' => $daily_course_id]);
        if (strtotime($dailyCourseModel->date) == strtotime(date('y-m-d', time()))) {
            // 当天日期
            if (!$this->actionTimeDiff($dailyCourseModel)) {
                return ['code' => '501', 'data' => false, 'message' => '请提前' . Yii::$app->cache->get('expired_time') . "小时预约"];
            }
        }
        if (($dailyCourseModel->entrance_count - $dailyCourseModel->remain) == 0) {
            return ['code' => '501', 'data' => false, 'message' => '该课程预约已满'];
        }
        // $record = UserEntranceModel::find()->where(['daily_course_id' => $daily_course_id])->filterWhere(['user_id' => $user_id])->all();
        // if ($record) {
        //     return ['code' => '501', 'data' => false, 'message' => '您已预约该课程'];
        // }
        $transaction = Yii::$app->db->beginTransaction();
        $model = new UserEntranceModel();
        $model->setAttributes([
            'user_id' => $user_id,
            'daily_course_id' => $daily_course_id,
        ]);
        if ($model->save()) {
            $dailyCourseModel->remain += 1;
            if ($dailyCourseModel->save()) {
                $business->remain -= 1;
                if ($business->save()) {
                    $transaction->commit();
                    return ['code' => '000', 'data' => true, 'message' => '预约成功'];
                } else {
                    $transaction->rollBack();
                }
            }
        }
    }

    public function actionNotice()
    {
        $cache = Yii::$app->cache;
        return $cache->get('notice');
    }

    public function actionTimeDiff($dailyCourseModel)
    {
        $index = strpos($dailyCourseModel->time, ':');
        $hour = substr($dailyCourseModel->time, 0, $index);
        $min = substr($dailyCourseModel->time, $index + 1, strlen($dailyCourseModel->time));
        $expired_time = Yii::$app->cache->get('expired_time') == null ? 2 : Yii::$app->cache->get('expired_time');
        if (mktime($hour - $expired_time, $min) > strtotime(date('H:i', time()))) {
            return true;
        }
        return false;
    }

}