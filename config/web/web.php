<?php

$container = dirname(__DIR__, 2);
$config = [
    'id' => 'codices',
    'basePath' => '@app',
    'controllerNamespace' => 'App\Controller',
    'defaultRoute' => 'app/index',
    'components' => [
        'view' => [
            'class' => 'App\Component\View',
        ],
        'request' => [
            'csrfParam' => '_csrfweb', //TODO: Na aplicação/JS o nome do parâmetros é usado hardcoded
            'cookieValidationKey' => 'YlV8KprFK7TMDxhZDZC50peVGGVIGlfC',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'App\Security\Identity',
            'enableSession' => true,
            'enableAutoLogin' => false,
            'loginUrl' => ['app/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'app/error'
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'cache' => 'cache'
            //            [
            //                'class' => 'yii\caching\ApcCache',
            //                'useApcu' => true
            //            ]
        ],
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => ['css' => [], 'js' => []]
            ]
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'nullDisplay' => ''
        ],
    ],
    'params' => [
        //'bsVersion' => '4.x',
        //'bsDependencyEnabled' => false,
        //'cors-origins' => [],
    ]
];

if (YII_ENV === 'prod') {
    $prod = realpath(dirname(__DIR__, 1) . '/env/prod/params.php');
    if (is_file($prod)) {
        include $prod;
    }
}

if (YII_ENV === 'test') {
    $test = realpath(__DIR__ . '/env/test/params.php');
    if (defined('YII_DEBUG') && defined('YII_ENV') && YII_DEBUG && YII_ENV == 'test' &&
        is_file($test)) {

        include $test;
    }
}

if (YII_ENV === 'dev') {
    $dev = realpath(__DIR__ . '/env/dev/params.php');
    if (defined('YII_DEBUG') && defined('YII_ENV') && YII_DEBUG && YII_ENV == 'dev' &&
        is_file($dev)) {

        include $dev;
    }
}

return $config;
