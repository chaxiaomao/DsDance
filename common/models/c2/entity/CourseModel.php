<?php

namespace common\models\c2\entity;

use cza\base\models\statics\EntityModelStatus;
use Yii;

/**
 * This is the model class for table "{{%course}}".
 *
 * @property string $id
 * @property string $name
 * @property string $label
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class CourseModel extends \cza\base\models\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%course}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'label'], 'string', 'max' => 255],
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
            'name' => Yii::t('app.c2', 'Name'),
            'label' => Yii::t('app.c2', 'Label'),
            'status' => Yii::t('app.c2', 'Status'),
            'created_at' => Yii::t('app.c2', 'Created At'),
            'updated_at' => Yii::t('app.c2', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\c2\query\CourseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\c2\query\CourseQuery(get_called_class());
    }
    
    /**
    * setup default values
    **/
    public function loadDefaultValues($skipIfSet = true) {
        parent::loadDefaultValues($skipIfSet);
    }

    public static function getCourseHashMap()
    {
        $models = self::find()->where(['status' => EntityModelStatus::STATUS_ACTIVE])->all();
        $arrs = [];
        foreach ($models as $model) {
            $arrs[$model->id] = $model->name;
        }
        return $arrs;
    }

}
