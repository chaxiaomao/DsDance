<?php
defined('PROJECT_ROOT') or define('PROJECT_ROOT', dirname(dirname(__DIR__)));

$vendorDir = PROJECT_ROOT . '/vendor';
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => $vendorDir,
    'extensions' => require($vendorDir . '/cza/yii2-base/extensions.php'),
    'timeZone' => 'Asia/Shanghai',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@common/runtime/cache'
        ],
        'settings' => ['class' => 'common\components\Settings',],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => 'sc_auth_item',
            'assignmentTable' => 'sc_auth_assignment',
            'itemChildTable' => 'sc_auth_item_child',
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app.c2' => 'c2.php',
                        'app.sms' => 'sms.php',
                        'app.rest' => 'rest.php',
                    ],
                ],
            ],
        ],
    ],
];
