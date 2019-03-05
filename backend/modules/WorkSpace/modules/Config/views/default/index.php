<?php

use backend\modules\WorkSpace\modules\Config\widgets\GeneralPanel;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = Yii::t('app.c2', 'Params Settings');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app.c2', 'Configuration'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app.c2', 'Params Settings');
?>


<?= GeneralPanel::widget([
//    'withWechatTab' => true,
//    'withPerformanceTab' => false,
//    'withGeneralTab' => false,
//    'withApiTab' => false,
//    'withBusinessTab' => false,
//    'withUrlTab' => false,
//    'withGeoTab' => false,
    
    'withBusinessTab' => true,
    'withAccountTab' => true,

]); ?>
