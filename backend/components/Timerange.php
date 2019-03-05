<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/16
 * Time: 10:39
 */

namespace backend\components;
use yii\validators\ValidationAsset;
use backend\assets\TimerangeValidation;
use yii\helpers\Html;
use yii\validators\Validator;

class Timerange extends Validator{
    public $range;
    public $message;
    public $compareValue;
    public $compareAttribute;

    const TYPE_STRING = 'string';
    public $type = self::TYPE_STRING;

    public function init(){
        parent::init();
        if($this->message === null){
            $this->message = \Yii::t('yii','选择的日期范围不能大于6天".');
        }
    }

    public function clientValidateAttribute($model,$attribute,$view){
        TimerangeValidation::register($view);
        $options = $this->getClientOptions($model, $attribute);
        return 'yii.validation.timeRange(value, messages, ' . json_encode($options, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . ');';
    }

    public function getClientOptions($model, $attribute){
        $options = [
            'ranges' => $this->range,
            'type' => $this->type,
        ];

        if ($this->compareValue !== null) {
            $options['compareValue'] = $this->compareValue;
            $compareLabel = $compareValue = $compareValueOrAttribute = $this->compareValue;
        } else {
            $compareAttribute = $this->compareAttribute === null ? $attribute . '_repeat' : $this->compareAttribute;
            $compareValue = $model->getAttributeLabel($compareAttribute);
            $options['compareAttribute'] = Html::getInputId($model, $compareAttribute);
            $compareLabel = $compareValueOrAttribute = $model->getAttributeLabel($compareAttribute);
        }

        if ($this->skipOnEmpty) {
            $options['skipOnEmpty'] = 1;
        }

        $options['message'] = $this->formatMessage($this->message, [
            'attribute' => $model->getAttributeLabel($attribute),
            'compareAttribute' => $compareLabel,
            'compareValue' => $compareValue,
            'compareValueOrAttribute' => $compareValueOrAttribute,
        ]);

        return $options;
    }
}