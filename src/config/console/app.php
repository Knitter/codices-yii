<?php

declare(strict_types=1);

$parent = dirname(__DIR__);

/** @phpstan-var array<string, mixed> $aliases */
$aliases = require $parent . '/aliases.php';
/** @phpstan-var array<string, mixed> $bootstrap */
$bootstrap = require $parent . '/common/bootstrap.php';

/** @phpstan-var array<string, mixed> $components */
$components = require __DIR__ . '/components.php';
/** @phpstan-var array<string, mixed> $container */
$container = require __DIR__ . '/container.php';
/** @phpstan-var array<string, mixed> $params */
$params = require __DIR__ . '/params.php';

$config = [
    'id' => 'codices.console',
    'basePath' => '@root',
    'vendorPath' => '@root/vendor',
    'runtimePath' => '@root/runtime',
    'controllerNamespace' => 'Codices\Command',
    //
    'bootstrap' => $bootstrap,
    'components' => $components,
    'container' => $container,
    'params' => $params,
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationTable' => 'migration_history',
            'migrationPath' => ['@migrations'],
        ],
    ],
];

if (YII_ENV_PROD) {
    $override = $parent . '/envs/prod/console.php';
    if (is_file($override)) {
        include $override;
    }
}

if (YII_ENV_DEV) {
    $override = $parent . '/envs/dev/console.php';
    if (is_file($override)) {
        include $override;
    }
}

if (YII_ENV_TEST) {
    $override = $parent . '/envs/test/console.php';
    if (is_file($override)) {
        include $override;
    }
}

return $config;
