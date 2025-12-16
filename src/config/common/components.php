<?php

declare(strict_types=1);

use yii\caching\FileCache;
use yii\log\FileTarget;

return [
    'cache' => [
        'class' => FileCache::class,
    ],
    'log' => [
        'traceLevel' => YII_DEBUG ? 3 : 0,
        'targets' => [
            [
                'class' => FileTarget::class,
                'levels' => [
                    'error',
                    'info',
                    'warning',
                ],
                'logFile' => '@runtime/logs/app.log',
            ],
        ],
    ],
    'db' => [
        'class' => yii\db\Connection::class,
        'dsn' => 'sqlite:' . Yii::getAlias(getenv('CODICES_DB_PATH') ?: '@data/codices.sqlite'),
        'attributes' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ],
    ],
    'i18n' => [
        'translations' => [
            '*' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@messages'
            ]
        ]
    ],
];
