<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/5
 * Time: 23:50
 */

namespace common\models;


use cza\base\models\ModelTrait;
use yii\base\Model;

class BusinessConfigForm extends Model
{

    public $expired_hours = '';
    public $notice = '';

    use ModelTrait;

    public function rules()
    {
        return [
            ['expired_hours', 'default', 'value' => 6],
        ];
    }

    public function attributeLabels()
    {
        return [
            'expired_hours' => '提前时间',
            'notice' => '提示语'
        ];
    }

}