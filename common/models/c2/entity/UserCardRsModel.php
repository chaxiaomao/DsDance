<?php

namespace common\models\c2\entity;

use Yii;

/**
 * This is the model class for table "{{%user_card_rs}}".
 *
 * @property string $id
 * @property string $user_id
 * @property string $card_id
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class UserCardRsModel extends \cza\base\models\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_card_rs}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'card_id'], 'integer'],
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
            'user_id' => Yii::t('app.c2', 'User'),
            'card_id' => Yii::t('app.c2', 'Card'),
            'status' => Yii::t('app.c2', 'Status'),
            'created_at' => Yii::t('app.c2', 'Created At'),
            'updated_at' => Yii::t('app.c2', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\c2\query\UserCardRsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\c2\query\UserCardRsQuery(get_called_class());
    }

    /**
     * setup default values
     **/
    public function loadDefaultValues($skipIfSet = true)
    {
        parent::loadDefaultValues($skipIfSet);
    }

    public function getCard()
    {
        return $this->hasOne(CardModel::className(), ['id' => 'card_id']);
    }

    public function getUser()
    {
        return $this->hasOne(FeUserModel::className(), ['id' => 'user_id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        $model = UserBusinessModel::findOne(['user_id' => $this->user_id]);
        if (strtotime(date('y-m-d h:i:s', time())) > strtotime($model->period)) {
            // 过期
            $model->period = date('y-m-d',strtotime("+" . $this->card->period . "month"));
            $model->remain = $this->card->value;
        } else {
            $model->period = date('y-m-d', strtotime("+" . $this->card->period . "month", strtotime($model->period)));
            $model->remain += $this->card->value;
        }
        $model->save();
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

}
