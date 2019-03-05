<?php

namespace backend\modules\Business;

/**
 * business module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\Business\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        $this->modules = [
            'card' => [
                'class' => 'backend\modules\Business\modules\Card\Module',
            ],
        ];
    }
}
