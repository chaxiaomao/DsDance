<?php

use kartik\datecontrol\Module;

defined('APP_ROOT') or define('APP_ROOT', dirname(__DIR__));
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

$config = [
    'id' => 'app-backend',
    'language' => 'zh-CN',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        "admin" => [
            "class" => "mdm\admin\Module",
        ],
        'gridview' => [
            'class' => 'kartik\grid\Module'
        ],
        'work-space' => [
            'class' => 'backend\modules\WorkSpace\Module',
        ],
        'business' => [
            'class' => 'backend\modules\Business\Module',
        ],
        'datecontrol' => [
            'class' => 'kartik\datecontrol\Module',
            'displaySettings' => [
                Module::FORMAT_DATE => 'yyyy-MM-dd',
            ],
        ],
    ],
    "aliases" => [
        "@mdm/admin" => "@vendor/mdmsoft/yii2-admin",
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => ['*'], // 后面对权限完善了以后，记得把*改回来！
    ],
    'components' => [
        "authManager" => [
            "class" => 'yii\rbac\DbManager',
            "defaultRoles" => ["guest"],
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                'backendLog' => [
                    'class' => 'yii\log\FileTarget',
                    'logFile' => "@runtime/logs/backend_info.log",
                    'categories' => ['application'],
                    'levels' => ['info', 'trace'],
                    // belows setting will keep the log fresh
                    'maxFileSize' => 0,
                    'maxLogFiles' => 0,
                ],
                'backendSql' => [
                    'class' => 'yii\log\FileTarget',
                    'logFile' => "@runtime/logs/backend_sql.log",
                    'categories' => ['yii\db\*'],
                    'levels' => ['info'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'params' => $params,
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    // $config['modules']['debug'] = [
    //     'class' => 'yii\debug\Module',
    // ];
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*'],
        'panels' => [
            'views' => ['class' => 'cza\base\components\panels\debug\ViewsPanel'],
        ],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1'],
        'generators' => [ //here
            'crud' => [ // generator name
                'class' => 'cza\gii\generators\crud\Generator', // generator class
                'templates' => [ //setting for out templates
                    '[BO] CCA2-Default' => '@cza/gii/generators/crud/bo-default', // template name => path to template
                    '[BO] CCA2 Popup' => '@cza/gii/generators/crud/bo-popup',
                    'Yii Default' => '@yii/gii/generators/crud/default', // template name => path to template
                ]
            ],
            'controller' => ['class' => 'yii\gii\generators\controller\Generator'],
            'form' => ['class' => 'yii\gii\generators\form\Generator'],
            'extension' => ['class' => 'yii\gii\generators\extension\Generator'],
            //            'model' => ['class' => 'yii\gii\generators\model\Generator'],
            'model' => ['class' => 'cza\gii\generators\model\Generator'],
        ],
    ];
}

return $config;