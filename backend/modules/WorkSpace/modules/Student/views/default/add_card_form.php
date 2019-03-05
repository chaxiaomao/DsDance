<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/5
 * Time: 16:58
 */

use cza\base\widgets\ui\adminlte2\InfoBox;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use cza\base\models\statics\EntityModelStatus;

$messageName = $model->getMessageName();
?>

<?php
$form = ActiveForm::begin([
    'action' => ['add-card', 'id' => $model->id],
    'options' => [
        'id' => $model->getBaseFormName(),
        'data-pjax' => true,
    ]]);
?>
<div class="<?= $model->getPrefixName('form') ?>">

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

    <div class="well">
        <?php
        echo Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
                // 'registration_src_type' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items' => []],
                'username' => ['type' => Form::INPUT_TEXT, 'options' => [
                    'placeholder' => $model->getAttributeLabel('username'),
                    'value' => $user->username
                ]],
                'card_id' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items' => \common\models\c2\entity\CardModel::getCards()],
            ]
        ]);
        echo $form->field($model, 'user_id', [])->label(false)->hiddenInput(['value' => $user->id]);
        echo Html::beginTag('div', ['class' => 'box-footer']);
        echo Html::submitButton('<i class="fa fa-save"></i> ' . Yii::t('app.c2', 'Save'), ['type' => 'button', 'class' => 'btn btn-primary pull-right']);
        echo Html::endTag('div');
        ?>
    </div>

</div>

<?php ActiveForm::end(); ?>