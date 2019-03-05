<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


?>
<div class="daily-course-model-detail">

    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
                'id',
            'course_id',
            'user_id',
            'date',
            'time',
            'remain',
            'status',
            'created_at',
            'updated_at',
    ],
    ]) ?>

</div>

