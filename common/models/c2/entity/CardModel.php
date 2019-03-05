<?php

namespace common\models\c2\entity;

use cza\base\models\statics\EntityModelStatus;
use Yii;

/**
 * This is the model class for table "{{%card}}".
 *
 * @property string $id
 * @property string $name
 * @property string $label
 * @property integer $period
 * @property integer $value
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class CardModel extends \cza\base\models\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%card}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'period', 'value'], 'integer'],
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
            'period' => Yii::t('app.c2', 'Period'),
            'value' => Yii::t('app.c2', 'Count Value'),
            'status' => Yii::t('app.c2', 'Status'),
            'created_at' => Yii::t('app.c2', 'Created At'),
            'updated_at' => Yii::t('app.c2', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\c2\query\CardQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\c2\query\CardQuery(get_called_class());
    }
    
    /**
    * setup default values
    **/
    public function loadDefaultValues($skipIfSet = true) {
        parent::loadDefaultValues($skipIfSet);
    }

    public function getMonths()
    {
        return [
            '1' => '1个月',
            '2' => '2个月',
            '3' => '3个月',
            '4' => '4个月',
            '5' => '5个月',
            '6' => '6个月',
            '7' => '7个月',
            '8' => '8个月',
            '9' => '9个月',
            '10' => '10个月',
            '11' => '11个月',
            '12' => '12个月',
        ];
    }

    public static function getCards() {
        $models = self::find()->where(['status' => EntityModelStatus::STATUS_ACTIVE])->all();
        $arrs = [];
        foreach ($models as $model) {
            $arrs[$model->id] = $model->name;
        }
        return $arrs;
    }

}
