<?php

use yii\symfonymailer\Mailer;

$config = [
    'name' => 'Codices',
    'vendorPath' => '@container/vendor',
    'aliases' => [
        '@bower' => '@container/vendor/bower-asset',
        '@npm' => '@container/vendor/npm-asset',
    ],
    //'sourceLanguage' => 'pt-PT',
    'language' => 'pt-PT',
    'components' => [
        'cache' => [
            //'class' => \yii\caching\FileCache::class,
            'class' => 'yii\caching\ApcCache',
            'useApcu' => true
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages'
                ]
            ]
        ],
        'mailer' => [
            'class' => Mailer::class,
            'useFileTransport' => true,
            //'transport' => [
            //    'scheme' => 'smtp',
            //    'host' => '<server IP>',
            //    'port' => 25,
            //    'options' => ['ssl' => true]
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
            'dsn' => '',
            'charset' => 'utf8',
            'enableSchemaCache' => true,
            'schemaCacheDuration' => (24 * 60 * 60),
            'schemaCache' => 'cache'
        ]
    ],
    'params' => [
        'appdata' => realpath(__DIR__ . '/../../appdata'),
        'email' => [
            'from' => 'example@someplace.moc'
        ],
    ]
];

$prod = realpath(__DIR__ . '/main.prod.php');
if (is_file($prod)) {

    include $prod;
}

$test = realpath(__DIR__ . '/main.test.php');
if (defined('YII_DEBUG') && defined('YII_ENV') && YII_DEBUG && YII_ENV == 'test' &&
    is_file($test)) {

    include $test;
}

$dev = realpath(__DIR__ . '/main.dev.php');
if (defined('YII_DEBUG') && defined('YII_ENV') && YII_DEBUG && YII_ENV == 'dev' &&
    is_file($dev)) {

    include $dev;
}

return $config;
