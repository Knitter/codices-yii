<?php

declare(strict_types=1);

use yii\i18n\PhpMessageSource;

/** @phpstan-var string[] $commonComponents */
$commonComponents = require dirname(__DIR__) . '/common/components.php';

$config = [
    'assetManager' => [
        'basePath' => '@assets',
        'bundles' => [
            'yii\bootstrap\BootstrapAsset' => ['css' => [], 'js' => []]
        ]
    ],
    'user' => [
        'identityClass' => 'core\components\Identity',
        'enableSession' => true,
        'enableAutoLogin' => false,
        'loginUrl' => ['app/login'],
    ],
    'errorHandler' => [
        'errorAction' => 'app/error',
    ],
    'formatter' => [
        'class' => 'yii\i18n\Formatter',
        'nullDisplay' => ''
    ],
    'request' => [
        'cookieValidationKey' => 'Y008KprFAFTMashZDZC50pe5687IGlfC',
        'parsers' => [
            'application/json' => 'yii\web\JsonParser',
        ],
    ],
    'urlManager' => [
        'enablePrettyUrl' => true,
        'showScriptName' => false,
    ],
];

$config += $commonComponents;
return $config;
