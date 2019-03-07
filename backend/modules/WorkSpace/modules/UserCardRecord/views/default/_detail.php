<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


?>
<div class="user-card-rs-model-detail">

    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
                'id',
            'user_id',
            'card_id',
            'status',
            'created_at',
            'updated_at',
    ],
    ]) ?>

</div>

