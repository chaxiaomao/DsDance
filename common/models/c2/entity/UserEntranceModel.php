<?php

namespace common\models\c2\entity;

use Yii;

/**
 * This is the model class for table "{{%user_entrance}}".
 *
 * @property string $id
 * @property string $daily_course_id
 * @property string $user_id
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class UserEntranceModel extends \cza\base\models\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_entrance}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['daily_course_id', 'user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
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
            'daily_course_id' => Yii::t('app.c2', 'Course'),
            'user_id' => Yii::t('app.c2', 'User'),
            'status' => Yii::t('app.c2', 'Status'),
            'created_at' => Yii::t('app.c2', 'Created At'),
            'updated_at' => Yii::t('app.c2', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\c2\query\UserEntranceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\c2\query\UserEntranceQuery(get_called_class());
    }
    
    /**
    * setup default values
    **/
    public function loadDefaultValues($skipIfSet = true) {
        parent::loadDefaultValues($skipIfSet);
    }

    public function getDailyCourse() {
        return $this->hasOne(DailyCourseModel::className(), ['id' => 'daily_course_id']);
    }

    public function getUser()
    {
        return $this->hasOne(FeUserModel::className(), ['id' => 'user_id']);
    }

}
