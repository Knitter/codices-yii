<?php

declare(strict_types=1);

$config['bootstrap'][] = 'debug';
$config['modules']['debug'] = [
    'class' => 'yii\debug\Module',
    'allowedIPs' => ['*', '127.0.0.1', '::1'],
    'panels' => [
        'user' => [
            'class' => 'yii\debug\panels\UserPanel',
            'ruleUserSwitch' => [
                'allow' => true
            ]
        ]
    ]
];

$config['components']['request']['cookieValidationKey'] = '__dummy__';
unset($config['components']['cache']);
unset($config['components']['urlManager']['cache']);
