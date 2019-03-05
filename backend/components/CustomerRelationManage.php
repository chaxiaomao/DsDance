<?php
/**
 * Created by PhpStorm.
 * User: chenangel
 * Date: 2017/6/19
 * Time: 上午9:45
 */

namespace backend\components;


use common\models\c2\entity\FeUser;
use common\models\c2\statics\FeUserType;

class CustomerRelationManage
{

    /**
     * customer relationship management
     */
    public function customerRelationManagement($id,$status){
        $model = \Yii::$app->db
            ->createCommand("SELECT * FROM c2_fe_user WHERE id = :id")
            ->bindValue(':id',$id)
            ->queryOne();
        switch ($model['type']){
            case FeUserType::TYPE_DISTRIBUTOR:
                $this->distributorStatus($model['id'],$status);
                break;
            case FeUserType::TYPE_FRANCHISEE:
                $this->franchiseeStatus($model['id'],$status);
                break;
            case FeUserType::TYPE_MERCHANT:
                $this->merchantStatus($model['id'],$status);
                break;
            case FeUserType::TYPE_SALESMAN:
                $this->salesmanStatus($model['id'],$status);
                break;
            default:
                break;
        }
    }

    public function distributorStatus($distributor_id,$status){
       // \Yii::info('distributorStatus' . $distributor_id . '用户ID' . $status);
        $res = \Yii::$app->db->createCommand()->update('c2_fe_user',['status' => $status],['id'=>$distributor_id])->execute();
        $res2 = \Yii::$app->db->createCommand()->update('c2_fe_user_profile',['status' => $status],['user_id'=>$distributor_id])->execute();
        if (!($res && $res2)) return false;
        $franchiseeRsFranchiseesModel = (new \Yii\db\Query())->select('franchisee_id')
            ->from('c2_distributor_franchisee_rs')
            ->where(['distributor_id'=>$distributor_id])
            ->all();
            foreach ($franchiseeRsFranchiseesModel as $k => $v){
                $this->franchiseeStatus($v['id'],$status);
            }
    }

    public function franchiseeStatus($franchisee_id,$status){//franchisee/shop/merchant
        $res = \Yii::$app->db->createCommand()->update('c2_fe_user',['status' => $status],['id'=>$franchisee_id])->execute();
        $res2 = \Yii::$app->db->createCommand()->update('c2_fe_user_profile',['status' => $status],['user_id'=>$franchisee_id])->execute();
        if (!($res && $res2)) return false;

        $franchiseeRsShopModel = (new \Yii\db\Query())->select('id')
            ->from('c2_shop')
            ->where(['franchisee_id'=>$franchisee_id])
            ->all();

            foreach ($franchiseeRsShopModel as $k => $v){
                $this->shopStatus($v['id'],$status);
            }
    }

    public function shopStatus($shop_id,$status){//shop\merchant
        $res = \Yii::$app->db->createCommand()->update('c2_shop',['status' => $status],['id'=>$shop_id])->execute();
        $res2 = \Yii::$app->db->createCommand()->update('c2_shop_profile',['status' => $status],['shop_id'=>$shop_id])->execute();
        if (!($res && $res2)) return false;

        $merchantmodel = (new \Yii\db\Query())->select('merchant_id')
            ->from('c2_shop')
            ->andWhere(['id'=>$shop_id])
            ->find();
        $this->merchantStatus($merchantmodel['merchant_id'],$status);

    }

    public function merchantStatus($merchant_id,$status){//merchant
        $res = \Yii::$app->db->createCommand()->update('c2_fe_user',['status' => $status],['id'=>$merchant_id])->execute();
        $res2 = \Yii::$app->db->createCommand()->update('c2_fe_user_profile',['status' => $status],['user_id'=>$merchant_id])->execute();
        $res&&$res2 ? true : false;

    }

    public static function salesmanStatus($salesman_id = null,$status = 2){//salesman/customer
        $res = \Yii::$app->db->createCommand()->update('c2_fe_user',['status' => $status],['id'=>$salesman_id])->execute();
        $res2 = \Yii::$app->db->createCommand()->update('c2_fe_user_profile',['status' => $status],['user_id'=>$salesman_id])->execute();
        if (!($res && $res2)) return false;
        $salemanRsCustomerModel = (new \Yii\db\Query())->select('customer_id')
            ->from('c2_salesman_customer_rs')
            ->where(['salesman_id'=>$salesman_id])
            ->all();
        if (count($salemanRsCustomerModel)>0) {
            $whereData = [];
            $whereData2 = [];
            foreach ($salemanRsCustomerModel as $k => $v) {
                $whereData['id'][] = $v['customer_id'];
                $whereData2['user_id'][] = $v['customer_id'];
            }
            $statusQuery = \Yii::$app->db->createCommand()->update('c2_fe_user', ['status' => $status], $whereData)->execute();
            $statusQuery2 = \Yii::$app->db->createCommand()->update('c2_fe_user_profile', ['status' => $status], $whereData2)->execute();
            count($statusQuery)>0 && count($statusQuery2) ? true : false;
        }else{
            return true;
        }
        return false;

        //\Yii::info('专员和客户的关系' . json_encode($salemanRsCustomerModel) . '===' . json_encode($statusQuery) . '用户ID');
    }


}