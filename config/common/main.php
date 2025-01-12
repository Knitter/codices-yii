<?php

use yii\symfonymailer\Mailer;

$config = [
    'name' => 'Codices',
    'vendorPath' => '@container/vendor',
    'aliases' => [
        '@bower' => '@container/vendor/bower-asset',
        '@npm' => '@container/vendor/npm-asset',
    ],
    'sourceLanguage' => 'pt-PT',
    'language' => 'pt-PT',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\ApcCache',
            'useApcu' => true
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@messages'
                ]
            ]
        ],
        'mailer' => [
            'class' => Mailer::class,
            'useFileTransport' => true,
            //'transport' => [
            //    'scheme' => 'smtp',
            //    'host' => '',
            //    'port' => ,
            //    'options' => ['ssl' => false|true]
            //],
        ],
        'log' => [
            'traceLevel' => 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning']
                ]
            ]
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            //'dsn' => '',
            'charset' => 'utf8',
            'enableSchemaCache' => true,
            'schemaCacheDuration' => (24 * 60 * 60),
            'schemaCache' => 'cache'
        ],
    ],
];
