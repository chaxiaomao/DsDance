<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


?>
<div class="card-model-detail">

    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
                'id',
            'name',
            'label',
            'period',
            'value',
            'status',
            'created_at',
            'updated_at',
    ],
    ]) ?>

</div>

