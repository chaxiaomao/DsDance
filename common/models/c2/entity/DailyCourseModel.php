<?php

namespace common\models\c2\entity;

use Yii;

/**
 * This is the model class for table "{{%daily_course}}".
 *
 * @property string $id
 * @property string $course_id
 * @property string $user_id
 * @property string $date
 * @property string $time
 * @property integer $remain
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class DailyCourseModel extends \cza\base\models\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%daily_course}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_id', 'user_id', 'remain'], 'integer'],
            [['date', 'created_at', 'updated_at'], 'safe'],
            [['time'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app.c2', 'ID'),
            'course_id' => Yii::t('app.c2', 'Course'),
            'user_id' => Yii::t('app.c2', 'Teacher'),
            'date' => Yii::t('app.c2', 'Course Date'),
            'time' => Yii::t('app.c2', 'Course Time'),
            'remain' => Yii::t('app.c2', 'Course Remain'),
            'status' => Yii::t('app.c2', 'Status'),
            'created_at' => Yii::t('app.c2', 'Created At'),
            'updated_at' => Yii::t('app.c2', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\c2\query\DailyCourseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\c2\query\DailyCourseQuery(get_called_class());
    }
    
    /**
    * setup default values
    **/
    public function loadDefaultValues($skipIfSet = true) {
        parent::loadDefaultValues($skipIfSet);
    }

    public function getUser()
    {
        return $this->hasOne(FeUserModel::className(), ['id' => 'user_id']);
    }

    public function getCourse()
    {
        return $this->hasOne(CourseModel::className(), ['id' => 'course_id']);
    }

}
