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
/** @phpstan-var array<string, mixed> $modules */
$modules = require __DIR__ . '/modules.php';
/** @phpstan-var array<string, mixed> $params */
$params = require __DIR__ . '/params.php';

$config = [
    'id' => 'codices.web',
    'basePath' => '@root',
    'vendorPath' => '@root/vendor',
    'runtimePath' => '@root/runtime',
    'viewPath' => '@views',
    'layoutPath' => '@layout',
    'controllerNamespace' => 'Codices\Controller',
    'defaultRoute' => 'app/index',
    'language' => 'en-US',
    'name' => 'Codices',
    //
    'bootstrap' => $bootstrap,
    'components' => $components,
    'container' => $container,
    'modules' => $modules,
    'params' => $params,
];

if (YII_ENV_PROD) {
    $override = $parent . '/envs/prod/web.php';
    if (is_file($override)) {
        include $override;
    }
}

if (YII_ENV_DEV) {
    $override = $parent . '/envs/dev/web.php';
    if (is_file($override)) {
        include $override;
    }
}

if (YII_ENV_TEST) {
    $override = $parent . '/envs/test/web.php';
    if (is_file($override)) {
        include $override;
    }
}

return $config;
