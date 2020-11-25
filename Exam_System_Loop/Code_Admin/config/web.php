<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => 'index/index',

    //模块
    'modules' => [
        //系统管理模块
        'system' => [
            'class' => 'app\modules\system\module',
            'layout' => '//lte_main',
        ],
        //考试管理模块
        'exam' => [
            'class' => 'app\modules\exam\module',
            'layout' => '//lte_main',
        ],
        //基本信息管理
        'systembase' => [
            'class' => 'app\modules\systembase\module',
            'layout' => '//lte_main',
        ],
        //系统数据管理
        'systemdata' => [
            'class' => 'app\modules\systemdata\module',
            'layout' => '//lte_main',
        ],
        //教育计划管理
        'teachplan' => [
            'class' => 'app\modules\teachplan\module',
            'layout' => '//lte_main',
        ],
        //题库管理
        'question' => [
            'class' => 'app\modules\question\module',
            'layout' => '//lte_main',
        ],
        //成绩管理
        'grade' => [
            'class' => 'app\modules\grade\module',
            'layout' => '//lte_main',
        ],
        //预约系统管理
        'reservation' => [
            'class' => 'app\modules\reservation\module',
            'layout' => '//lte_main',
        ],

        //前台
        'front' =>[
            'class' => 'app\modules\front\module',
            'layout' => '//front'
        ],

        //教学辅助
        'aid' => [
            'class' => 'app\modules\aid\module',
            'layout' => '//lte_main'
        ]

    ],


    'components' => [
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => '172.16.1.17',
            'port' => 6379,
            'database' => 0,
        ],
        'session' => [
            'class' => 'yii\redis\Session',
            'redis' =>'redis',
        ],
        //RBAC权限管理
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => 'auth_item',
            'assignmentTable' => 'auth_assignment',
            'itemChildTable' => 'auth_item_child',
            'ruleTable' => 'auth_rule',
        ],

        'request' => [
            'cookieValidationKey' => 'fuck yii',
        ],

        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        //用户登录验证组件
        'user' => [
            'class'=>'yii\web\User',
            'identityClass' => 'app\models\TbcuitmoonUser',
            'enableAutoLogin' => true,
            'enableSession'=>true,
        ],

        'stu' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\models\systembase\Studentinfo',
            'enableAutoLogin' => true,
            'enableSession' => true,
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
        'db' => require(__DIR__ . '/db.php'),
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
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
