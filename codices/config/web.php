<?php

$map = [];
$file = realpath(__DIR__ . '/asset-map.php');
if (is_file($file)) {
    $map = include $file;
    if (!is_array($map)) {
        $map = [];
    }
}

$config = [
    'id' => 'codices',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'codices\controllers',
    'defaultRoute' => 'main/index',
    'components' => [
        'view' => [
            'class' => 'codices\components\View',
        ],
        'request' => [
            'csrfParam' => '_csrfweb',
            'cookieValidationKey' => 'Y597KprKOYTMDxhfalpw50peV00V45l98',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'codices\models\User',
            'enableSession' => true,
            'enableAutoLogin' => true,
            'loginUrl' => ['main/login'],
            'identityCookie' => ['name' => '_identity-codices', 'httpOnly' => true],
        ],
        'errorHandler' => [
            'errorAction' => 'main/error'
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
                'yii\bootstrap5\BootstrapAsset' => ['css' => [], 'js' => []]
            ]
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'nullDisplay' => ''
        ],
    ],
    'params' => [
        //'defaultResultsPerPage' => 50,
        //'bsVersion' => '4.x',
        //'bsDependencyEnabled' => false,
        'assets' => $map
    ]
];

$prod = realpath(__DIR__ . '/web.prod.php');
if (is_file($prod)) {

    include $prod;
}

$test = realpath(__DIR__ . '/web.test.php');
if (defined('YII_DEBUG') && defined('YII_ENV') && YII_DEBUG && YII_ENV == 'test' &&
    is_file($test)) {

    include $test;
}

$dev = realpath(__DIR__ . '/web.dev.php');
if (defined('YII_DEBUG') && defined('YII_ENV') && YII_DEBUG && YII_ENV == 'dev' &&
    is_file($dev)) {

    include $dev;
}

return $config;
