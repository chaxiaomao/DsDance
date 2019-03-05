<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


?>
<div class="course-model-detail">

    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
                'id',
            'name',
            'label',
            'status',
            'created_at',
            'updated_at',
    ],
    ]) ?>

</div>

