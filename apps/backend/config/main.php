<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'language'=> 'id',
    'name' => 'RANDIS',
    'modules' => [
        'users' => [
            'class' => 'backend\modules\users\Module',
        ],
        'gridview' => [ 'class' => '\kartik\grid\Module' ],
        'adminer' => [
            'class' => 'backend\modules\adminer\Module',
            'as access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function () {
                            // Here you define the conditions to make sure it's
                            // only accessible by an administrator, for example.
                            $canAccess = true;
                            return $canAccess;
                        }
                    ],
                ],
            ],
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        /*
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        */
        'user' => [
            'identityClass' => 'common\models\User',
            'loginUrl' => ['site/login'],
            'enableAutoLogin' => true,
            //'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'as loginOnce' => [  // <- bagian ini yg penting
                'class' => 'common\classes\LoginOnce',
                'kickLogedUser' => true,
                'throwExeption' => false,
            ]
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            //'name' => 'advanced-backend',
            'class' => 'yii\web\DbSession',
            'sessionTable' => 'session',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                //['class' => 'common\helpers\UrlRule', 'connectionID' => 'db'],
            ],
        ],
    ],
    'params' => $params,
];
