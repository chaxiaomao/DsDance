<?php

namespace backend\modules\WorkSpace;

/**
 * work-space module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\WorkSpace\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        $this->modules = [
            'student' => [
                'class' => 'backend\modules\WorkSpace\modules\Student\Module',
            ],
        ];
    }
}
