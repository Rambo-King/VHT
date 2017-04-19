<?php
//Yii::setAlias('@common', dirname(__DIR__) . '/common');
$params = require(__DIR__ . '/params.php');

$config = [
    'timeZone'=>'Asia/Chongqing',
    'language' =>'en', //zh-CN
    'id' => 'vht',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller:[-\w]+>/<action:[-\w]+>/<id:\d+>' => '<controller>/<action>',
                '<controller:[-\w]+>/<action:[-\w]+>' => '<controller>/<action>',
                '<module:[\w]+>/<controller:[-\w]+>/<action:[-\w]+>/<id:\d+>' => '<module>/<controller>/<action>',
                '<module:[\w]+>/<controller:[-\w]+>/<action:[-\w]+>' => '<module>/<controller>/<action>',
            ],
        ],
        'request' => [
            'cookieValidationKey' => 'King',
            //'enableCsrfValidation' => false,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\models\Member',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_memberIdentity', 'httpOnly' => true],
            'idParam' => '_memberId',
            'loginUrl' => ['member/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'php:d-M-Y',
            'datetimeFormat' => 'php:d-M-Y H:i:s',
            'timeFormat' => 'php:H:i:s',
            'nullDisplay' => '',
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
        ],
    ],
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
