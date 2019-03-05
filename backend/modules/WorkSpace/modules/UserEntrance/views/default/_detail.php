<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


?>
<div class="user-entrance-model-detail">

    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
                'id',
            'daily_course_id',
            'user_id',
            'status',
            'created_at',
            'updated_at',
    ],
    ]) ?>

</div>

