<?php

declare(strict_types=1);

$parent = dirname(__DIR__);

/** @phpstan-var array<string, mixed> $aliases */
$aliases = require $parent . '/common/aliases.php';
/** @phpstan-var array<string, mixed> $bootstrap */
$bootstrap = require $parent . '/common/bootstrap.php';
/** @phpstan-var array<string, mixed> $components */
$components = require $parent . '/common/components.php';
/** @phpstan-var array<string, mixed> $container */
$container = require __DIR__ . '/container.php';
/** @phpstan-var array<string, mixed> $params */
$params = require __DIR__ . '/console.php';

return [
    'id' => 'codices.console',
    'aliases' => $aliases,
    'basePath' => '@console',
    'vendorPath' => '@vendor',
    'controllerNamespace' => 'Codices\Command',
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationTable' => 'migration_history',
        ],
        'migrationPath' => [
            '@migrations'
        ]
    ],
    'bootstrap' => $bootstrap,
    'components' => $components,
    'container' => $container,
    'params' => $params,
];

//$prod = realpath(__DIR__ . '/console.prod.php');
//if (is_file($prod)) {
//
//    include $prod;
//}
//
//$qa = realpath(__DIR__ . '/console.qa.php');
//if (is_file($qa)) {
//
//    include $qa;
//}
//
//$test = realpath(__DIR__ . '/console.test.php');
//if (defined('YII_DEBUG') && defined('YII_ENV') && YII_DEBUG && YII_ENV == 'test' &&
//    is_file($test)) {
//
//    include $test;
//}
//
//$dev = realpath(__DIR__ . '/console.dev.php');
//if (defined('YII_DEBUG') && defined('YII_ENV') && YII_DEBUG && YII_ENV == 'dev' &&
//    is_file($dev)) {
//
//    include $dev;
//}
//
//return $config;
