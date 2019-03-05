<?php

namespace common\models\c2\entity;

use Yii;

/**
 * This is the model class for table "{{%user_business}}".
 *
 * @property string $user_id
 * @property string $id
 * @property integer $remain
 * @property string $period
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class UserBusinessModel extends \cza\base\models\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_business}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'id', 'remain'], 'integer'],
            [['period', 'created_at', 'updated_at'], 'safe'],
            [['status'], 'integer', 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app.c2', 'User ID'),
            'remain' => Yii::t('app.c2', 'Remain'),
            'period' => Yii::t('app.c2', 'Period'),
            'status' => Yii::t('app.c2', 'Status'),
            'created_at' => Yii::t('app.c2', 'Created At'),
            'updated_at' => Yii::t('app.c2', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\c2\query\UserBusinessQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\c2\query\UserBusinessQuery(get_called_class());
    }
    
    /**
    * setup default values
    **/
    public function loadDefaultValues($skipIfSet = true) {
        parent::loadDefaultValues($skipIfSet);
    }

}
