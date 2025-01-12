<?php

return [
    'id' => 'codices-console',
    'basePath' => '@src',
    'controllerNamespace' => 'App\Command',
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'templateFile' => '@resources/views/migration.php',
        ],
    ],
    //    'components' => [
    //        'urlManager' => [
    //            'class' => 'yii\web\UrlManager',
    //            'enablePrettyUrl' => true,
    //            'showScriptName' => false,
    //            'baseUrl' => 'https://codices.xxx'
    //        ]
    //    ]
];
