<?php

return [
    'sourcePath' => dirname(__DIR__, 2) . '/src',
    'languages' => ['en'],
    'translator' => 'Yii::t',
    'sort' => false,
    'removeUnused' => false,
    'only' => ['*.php'],
    'except' => [
        '.git',
        '.gitignore',
        '.gitkeep',
        '/config',
        '/data',
        '/docs',
        '/public',
        '/migrations',
        '/runtime',
        '/tests',
        '/vendor'
    ],
    'format' => 'php',
    'messagePath' => dirname(__DIR__, 2) . '/resources/messages',
    'overwrite' => true
];
