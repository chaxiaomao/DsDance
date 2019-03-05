<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/31
 * Time: 9:42
 */

namespace backend\components;
use common\models\c2\entity\Shop;
use yii\validators\Validator;
use Yii;
class FranchiseeSystemValidate extends Validator
{
    public $skipOnEmpty = false;

    public $caseSensitive = false;

    public $compareAttribute;

    public $compareValue;

    public $transferLabel;

    public function init()
    {
        parent::init();
        switch ($this->transferLabel){
            case 'shop':
                if ($this->message === null) {
                    $this->message = Yii::t('app.c2', 'The original franchised store must be transferred with the target franchised store under the same franchisee!');
                }
            break;
        }

    }
    public function validateAttribute($model, $attribute){
        $originalValue = $model->$attribute;
        $target = $this->compareAttribute;
        $targetValue = $model->$target;
        if (is_array($originalValue)) {
            $this->addError($model, $attribute, Yii::t('yii', '{attribute} is invalid.'));
            return;
        }
        if ($this->compareValue !== null) {
            $compareLabel = $compareValue = $compareValueOrAttribute = $this->compareValue;
        } else {
            $compareAttribute = $this->compareAttribute === null ? $attribute . '_repeat' : $this->compareAttribute;
            $compareValue = $model->$compareAttribute;
            $compareLabel = $compareValueOrAttribute = $model->getAttributeLabel($compareAttribute);
        }
        if(!empty($originalValue) && !empty($targetValue)){
            switch ($this->transferLabel){
                case 'shop':
                    $originalFranchiseeId = Shop::find()->select('franchisee_id')->where(['id'=>$originalValue])->scalar();
                    $targetFranchiseeId = Shop::find()->select('franchisee_id')->where(['id'=>$targetValue])->scalar();
                    if($targetFranchiseeId != $originalFranchiseeId){
                        $this->addError($model, $attribute, $this->message, [
                            'compareAttribute' => $compareLabel,
                            'compareValue' => $compareValue,
                            'compareValueOrAttribute' => $compareValueOrAttribute,
                        ]);
                    }
                break;
                default:
                    return null;
                break;
            }
            return null;
        }
    }
}