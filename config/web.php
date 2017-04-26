<?php
//Yii::setAlias('@components', dirname(__DIR__) . '/components');
$params = require(__DIR__ . '/params.php');

$config = [
    'timeZone'=>'Asia/Chongqing',
    'language' =>'en',
    'id' => 'vht',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    //'defaultRoute' => 'member',
    /*'controllerMap' => [
        'api' => [
            'class' => 'app\api\ApiController'
        ]
    ],*/
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller:[-\w]+>/<action:[-\w]+>/<id:\d+>' => '<controller>/<action>',
                '<controller:[-\w]+>/<action:[-\w]+>' => '<controller>/<action>',
                '<module:[\w]+>/<controller:[-\w]+>/<action:[-\w]+>/<id:\d+>' => '<module>/<controller>/<action>',
                '<module:[\w]+>/<controller:[-\w]+>/<action:[-\w]+>' => '<module>/<controller>/<action>',
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/unit', 'api/network'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET api/unit/test' => 'api/unit/test',
                        'GET api/network/test1' => 'api/network/test1',
                    ]
                ],
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
        'admin' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\modules\admin\models\Manager',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_managerIdentity', 'httpOnly' => true],
            'idParam' => '_managerId',
            'loginUrl' => ['admin/manager/login'],
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
        'api' => [
            'class' => 'app\modules\api\Api',
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
