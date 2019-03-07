<?php

use cza\base\widgets\ui\common\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use cza\base\models\statics\EntityModelStatus;
use cza\base\models\statics\OperationEvent;

/* @var $this yii\web\View */
/* @var $searchModel common\models\c2\search\FeUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app.c2', 'Fe User Models');
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="well fe-user-model-index">

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,

            'pjax' => true,
            'hover' => true,
            'showPageSummary' => true,
            'panel' => ['type' => GridView::TYPE_PRIMARY, 'heading' => Yii::t('app.c2', 'Items')],
            'toolbar' => [
                [
                    'content' =>
                        Html::a('<i class="glyphicon glyphicon-plus"></i>', ['edit'], [
                            'class' => 'btn btn-success',
                            'title' => Yii::t('app.c2', 'Add'),
                            'data-pjax' => '0',
                        ]) . ' ' .
                        Html::button('<i class="glyphicon glyphicon-remove"></i>', [
                            'class' => 'btn btn-danger',
                            'title' => Yii::t('app.c2', 'Delete Selected Items'),
                            'onClick' => "jQuery(this).trigger('" . OperationEvent::DELETE_BY_IDS . "', {url:'" . Url::toRoute('multiple-delete') . "'});",
                        ]) . ' ' .
                        Html::a('<i class="glyphicon glyphicon-repeat"></i>', Url::current(), [
                            'class' => 'btn btn-default',
                            'title' => Yii::t('app.c2', 'Reset Grid')
                        ]),
                ],
                '{export}',
                '{toggleData}',
            ],
            'exportConfig' => [],
            'columns' => [
                ['class' => 'kartik\grid\CheckboxColumn'],
                ['class' => 'kartik\grid\SerialColumn'],
                [
                    'class' => 'kartik\grid\ExpandRowColumn',
                    'expandIcon' => '<span class="fa fa-plus-square-o"></span>',
                    'collapseIcon' => '<span class="fa fa-minus-square-o"></span>',
                    'detailUrl' => Url::toRoute(['detail']),
                    'value' => function ($model, $key, $index, $column) {
                        return GridView::ROW_COLLAPSED;
                    },
                ],
                'id',
                // 'type',
                // 'attributeset_id',
                'username',
                [
                    'attribute' => 'remain',
                    'label' => '剩余次数',
                    'value' => function ($model) {
                        return $model->userBusiness == null ? '未设置' : $model->userBusiness->remain;
                    },
                ],
                [
                    'label' => '到期时间',
                    'value' => function ($model) {
                        return $model->userBusiness == null ? '未设置' : date('Y-m-d', strtotime($model->userBusiness->period));
                    },
                ],
                // 'email:email',
                // 'password_hash',
                // 'auth_key',
                // 'confirmed_at',
                // 'unconfirmed_email:email',
                // 'blocked_at',
                // 'registration_ip',
                // 'registration_src_type',
                // 'flags',
                // 'level',
                // 'last_login_at',
                // 'last_login_ip',
                // 'open_id',
                // 'wechat_union_id',
                // 'wechat_open_id',
                // 'mobile_number',
                // 'sms_receipt',
                // 'access_token',
                // 'password_reset_token',
                // 'province_id',
                // 'city_id',
                // 'created_by',
                // 'updated_by',
                // 'status',
                // 'position',
                // 'created_at',
                // 'updated_at',
                [
                    'attribute' => 'status',
                    'class' => '\kartik\grid\EditableColumn',
                    'editableOptions' => [
                        'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                        'formOptions' => ['action' => Url::toRoute('editColumn')],
                        'data' => EntityModelStatus::getHashMap('id', 'label'),
                        'displayValueConfig' => EntityModelStatus::getHashMap('id', 'label'),
                    ],
                    'filter' => EntityModelStatus::getHashMap('id', 'label'),
                    'value' => function ($model) {
                        return $model->getStatusLabel();
                    }
                ],
                [
                    'class' => '\kartik\grid\ActionColumn',
                    'template' => '{add} {view} {card-record} {update} {delete}',
                    'buttons' => [
                        'add' => function ($url, $model, $key) {
                            return Html::a('添加卡券', '#', [
                                'class' => 'activity-view-link',
                                'title' => Yii::t('app', '添加卡券'),
                                'data-toggle' => 'modal',
                                'data-target' => '#add-modal',
                                'data-id' => $key,
                                'data-pjax' => '0',
                                'data-value' => Url::toRoute(['add-card', 'user_id' => $model->id]),
                            ]);
                        },
                        'update' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['edit', 'id' => $model->id], [
                                'title' => Yii::t('app', 'Info'),
                                'data-pjax' => '0',
                            ]);
                        },
                        'card-record' => function ($url, $model, $key) {
                            return Html::a('查看卡券', Url::toRoute(['/work-space/user-card-record/default/index', 'UserCardRsSearch[user_id]' => $model->id]));
                        },
                    ]
                ],
            ],
        ]); ?>

    </div>
<?php
Modal::begin([
    'id' => 'add-modal',
    'header' => '<h4 class="modal-title"></h4>',
    // 'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">关闭</a>',
]);
$js = <<<JS
$(document).off('click', '.activity-view-link').on('click','.activity-view-link',function(){
    content = $(this).attr('data-value');
    // console.log(content);
    $(".modal-title").html($(this).attr('data-title'));
    $($(this).attr('data-target')).modal("show")
        .find(".modal-body")
        .load(content);
    return false;
});
JS;
Modal::end();
$this->registerJs($js);
?>