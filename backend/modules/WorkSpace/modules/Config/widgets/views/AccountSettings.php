<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/5
 * Time: 23:37
 */

use cza\base\widgets\ui\adminlte2\InfoBox;
use kartik\form\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\widgets\Pjax;

$messageName = $model->getMessageName();
?>

<?php Pjax::begin(['id' => $model->getPjaxName(), 'formSelector' => $model->getBaseFormName(true), 'enablePushState' => false]) ?>

<?php if (Yii::$app->session->hasFlash($messageName)): ?>
    <?php if (!$model->hasErrors()) {
        echo InfoBox::widget([
            'withWrapper' => false,
            'messages' => Yii::$app->session->getFlash($messageName),
        ]);
    } else {
        echo InfoBox::widget([
            'defaultMessageType' => InfoBox::TYPE_WARNING,
            'messages' => Yii::$app->session->getFlash($messageName),
        ]);
    }
    ?>
<?php endif; ?>

<?php
$form = ActiveForm::begin([
    'action' => ['params-save',],
    'options' => [
        'id' => $model->getBaseFormName(),
        'data-pjax' => false,
    ]]);
?>

    <div class="well">
        <?php
        echo Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
                'expired_hours' => ['type' => Form::INPUT_TEXT, 'options' => ['type' => 'number', 'placeholder' => "设置禁止预约课程的提前时间，如：3"]],
                'notice' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('notice')]],
            ]
        ]);
        echo Html::beginTag('div', ['class' => 'box-footer']);
        echo Html::submitButton('<i class="fa fa-save"></i> ' . Yii::t('app.c2', 'Save'), ['type' => 'button', 'class' => 'btn btn-primary pull-right']);
        echo Html::a('<i class="fa fa-arrow-left"></i> ' . Yii::t('app.c2', 'Go Back'), ['index'], ['data-pjax' => '0', 'class' => 'btn btn-default pull-right', 'title' => Yii::t('app.c2', 'Go Back'),]);
        echo Html::endTag('div');
        ?>
    </div>

<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>