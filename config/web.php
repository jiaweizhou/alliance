<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
	'modules' => [
			'v1' => 'app\modules\v1\alliance',  // 后台模块引用
			
			//'v1talkbar'=>'app\modules\v1\controllers\talkbar',
	],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'wZMRuvznzz-AUm2z4w2wkiI_cqhvZ2cn',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
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
        'urlManager' => [
        	'enablePrettyUrl' => true,
        	'showScriptName' => false,
        	'rules' => [
        		///"/v1/talkbar/<controller:\w+>/<action:\w+>/<id:\d+>"=>"/app/modules/v1/controllers/talkbar/<controller>/<action>",
        		//"<module:\w+>/<module1:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>" => "<module>/<controller>/<action>",
        		"<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>" => "<module>/<controller>/<action>",
        		"<controller:\w+>/<action:\w+>/<id:\d+>" => "<controller>/<action>",
        		"<controller:\w+>/<action:\w+>" => "<controller>/<action>",
        //"<module:\w+>/<version:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>" => "<module>/<version>/<controller>/<action>",
        ]
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
