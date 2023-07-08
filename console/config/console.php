<?php

$config = [
    'id' => 'codices-console',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'console\commands',
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationTable' => 'yii_migration_ctrl',
            'templateFile' => '@console/views/migration.php',
        ],
    ],
    'components' => [
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'baseUrl' => ''
        ]
    ]
];

$prod = realpath(__DIR__ . '/console.prod.php');
if (is_file($prod)) {

    include $prod;
}

$test = realpath(__DIR__ . '/console.test.php');
if (defined('YII_DEBUG') && defined('YII_ENV') && YII_DEBUG && YII_ENV == 'test' &&
    is_file($test)) {

    include $test;
}

$dev = realpath(__DIR__ . '/console.dev.php');
if (defined('YII_DEBUG') && defined('YII_ENV') && YII_DEBUG && YII_ENV == 'dev' &&
    is_file($dev)) {

    include $dev;
}

return $config;