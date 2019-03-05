<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/30
 * Time: 19:47
 */

namespace backend\components;
use common\models\c2\entity\CommissionRecord;
use common\models\c2\statics\CommissionState;
use common\models\c2\statics\TransferType;
use yii\validators\Validator;
use Yii;
class SalesmanCommissionerValidate extends Validator{
    /**
     * @var bool whether to skip this validator if the input is empty.
     */
    public $skipOnEmpty = false;

    public $caseSensitive = false;

    public $validateType;

    public function init()
    {
        parent::init();
        if ($this->message === null) {
            switch ($this->validateType){
                case TransferType::DISTRIBUTOR_TRANSFER:
                    $this->message = Yii::t('app.c2', 'Non payment of remuneration by distributor');
                break;
                case TransferType::FRANCHISEE_TRANSFER:
                    $this->message = Yii::t('app.c2', 'Non payment of remuneration by franchisee');
                break;
                case TransferType::SHOP_TRANSFER:
                    $this->message = Yii::t('app.c2', 'Non payment of remuneration by shop');
                break;
            }

        }

    }

    protected function validateValue($value){
       if($value){
           switch ($this->validateType){
               case TransferType::DISTRIBUTOR_TRANSFER:
                   $valid =  CommissionRecord::find()->where(['AND',['distributor_id'=>$value,'state'=>CommissionState::TYPE_NOT_PAID]])->count();
                   return $valid <= 0 ? null : [$this->message, []];
                   break;
               case TransferType::FRANCHISEE_TRANSFER:
                   $valid =  CommissionRecord::find()->where(['AND',['franchisee_id'=>$value,'state'=>CommissionState::TYPE_NOT_PAID]])->count();
                   return $valid <= 0 ? null : [$this->message, []];
                   break;
               case TransferType::SHOP_TRANSFER:
                   $valid =  CommissionRecord::find()->where(['AND',['shop_id'=>$value,'state'=>CommissionState::TYPE_NOT_PAID]])->count();
                   return $valid <= 0 ? null : [$this->message, []];
               break;
               default:
                   return null;
           }

       }
    }


}