<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/31
 * Time: 11:33
 */

namespace backend\components;
use common\models\c2\entity\Franchisee;
use common\models\c2\entity\Shop;
use common\models\c2\search\DistributorFranchiseeRs;
use yii\validators\Validator;
use Yii;

class DistributorSystemValidate extends Validator
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
            case 'franchisee':
                if ($this->message === null) {
                    $this->message = Yii::t('app.c2', 'The original distributord franchisee must be in the same franchisee system as the target distributord franchisee!');
                }
                break;
            case 'shop':
                if ($this->message === null) {
                    $this->message = Yii::t('app.c2', 'The original store must be transferred with the target store under the same distribution!');
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
                case 'franchisee':
                    $originalDistributorId =DistributorFranchiseeRs::find()->select('distributor_id')->where(['franchisee_id'=>$originalValue])->scalar();
                    $targetDistributorId = DistributorFranchiseeRs::find()->select('distributor_id')->where(['franchisee_id'=>$targetValue])->scalar();
                    if($originalDistributorId != $targetDistributorId){
                        $this->addError($model, $attribute, $this->message, [
                            'compareAttribute' => $compareLabel,
                            'compareValue' => $compareValue,
                            'compareValueOrAttribute' => $compareValueOrAttribute,
                        ]);
                    }
                    break;
                case 'shop':
                    $originalDistributorId = Shop::find()->select('distributor_id')->where(['id'=>$originalValue])->scalar();
                    $targetDistributorId = Shop::find()->select('distributor_id')->where(['id'=>$targetValue])->scalar();
                    if($originalDistributorId != $targetDistributorId){
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