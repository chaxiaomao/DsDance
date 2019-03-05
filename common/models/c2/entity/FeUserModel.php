<?php

namespace common\models\c2\entity;

use cza\base\models\statics\EntityModelStatus;
use Yii;

/**
 * This is the model class for table "{{%fe_user}}".
 *
 * @property string $id
 * @property integer $type
 * @property string $attributeset_id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string $auth_key
 * @property string $confirmed_at
 * @property string $unconfirmed_email
 * @property string $blocked_at
 * @property string $registration_ip
 * @property integer $registration_src_type
 * @property integer $flags
 * @property integer $level
 * @property string $last_login_at
 * @property string $last_login_ip
 * @property string $open_id
 * @property string $wechat_union_id
 * @property string $wechat_open_id
 * @property string $mobile_number
 * @property string $sms_receipt
 * @property string $access_token
 * @property string $password_reset_token
 * @property string $province_id
 * @property string $city_id
 * @property string $created_by
 * @property string $updated_by
 * @property integer $status
 * @property integer $position
 * @property string $created_at
 * @property string $updated_at
 *
 * @property UserBusinessModel $userBusiness
 */
class FeUserModel extends \cza\base\models\ActiveRecord
{

    public $remain;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%fe_user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attributeset_id', 'flags', 'province_id', 'city_id', 'created_by', 'updated_by', 'position', 'registration_src_type'], 'integer'],
            [['username'], 'required'],
            [['confirmed_at', 'blocked_at', 'last_login_at', 'created_at', 'updated_at'], 'safe'],
            [['type', 'level', 'status'], 'integer', 'max' => 4],
            [['username', 'email', 'password_hash', 'auth_key', 'unconfirmed_email', 'registration_ip', 'last_login_ip', 'open_id', 'wechat_open_id', 'mobile_number', 'sms_receipt', 'access_token', 'password_reset_token'], 'string', 'max' => 255],
            [['wechat_union_id'], 'string', 'max' => 10],
            // ['registration_src_type', 'default', 'value' => '1'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app.c2', 'ID'),
            'type' => Yii::t('app.c2', 'Type'),
            'attributeset_id' => Yii::t('app.c2', 'Attributeset ID'),
            'username' => Yii::t('app.c2', 'Username'),
            'email' => Yii::t('app.c2', 'Email'),
            'password_hash' => Yii::t('app.c2', 'Password Hash'),
            'auth_key' => Yii::t('app.c2', 'Auth Key'),
            'confirmed_at' => Yii::t('app.c2', 'Confirmed At'),
            'unconfirmed_email' => Yii::t('app.c2', 'Unconfirmed Email'),
            'blocked_at' => Yii::t('app.c2', 'Blocked At'),
            'registration_ip' => Yii::t('app.c2', 'Registration Ip'),
            'registration_src_type' => Yii::t('app.c2', 'Registration Src Type'),
            'flags' => Yii::t('app.c2', 'Flags'),
            'level' => Yii::t('app.c2', 'Level'),
            'last_login_at' => Yii::t('app.c2', 'Last Login At'),
            'last_login_ip' => Yii::t('app.c2', 'Last Login Ip'),
            'open_id' => Yii::t('app.c2', 'Open ID'),
            'wechat_union_id' => Yii::t('app.c2', 'Wechat Union ID'),
            'wechat_open_id' => Yii::t('app.c2', 'Wechat Open ID'),
            'mobile_number' => Yii::t('app.c2', 'Mobile Number'),
            'sms_receipt' => Yii::t('app.c2', 'Sms Receipt'),
            'access_token' => Yii::t('app.c2', 'Access Token'),
            'password_reset_token' => Yii::t('app.c2', 'Password Reset Token'),
            'province_id' => Yii::t('app.c2', 'Province ID'),
            'city_id' => Yii::t('app.c2', 'City ID'),
            'created_by' => Yii::t('app.c2', 'Created By'),
            'updated_by' => Yii::t('app.c2', 'Updated By'),
            'status' => Yii::t('app.c2', 'Status'),
            'position' => Yii::t('app.c2', 'Position'),
            'created_at' => Yii::t('app.c2', 'Created At'),
            'updated_at' => Yii::t('app.c2', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserBusiness()
    {
        return $this->hasOne(UserBusinessModel::className(), ['user_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\c2\query\FeUserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\c2\query\FeUserQuery(get_called_class());
    }
    
    /**
    * setup default values
    **/
    public function loadDefaultValues($skipIfSet = true) {
        parent::loadDefaultValues($skipIfSet);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (!$this->userBusiness) {
            $business = new UserBusinessModel();
            $business->setAttributes([
                'user_id' => $this->id,
                'remain' => 0,
                'period' => date('y-m-d', time()),
            ]);
            $business->save();
        }
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

    public static function getUserHashMap() {
        $models = self::find()->where(['status' => EntityModelStatus::STATUS_ACTIVE])->all();
        $arrs = [];
        foreach ($models as $model) {
            $arrs[$model->id] = $model->username;
        }
        return $arrs;
    }

}
