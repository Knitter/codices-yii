<?php

return [
    'sourcePath' => dirname(__DIR__, 2) . '/console',
    'languages' => ['en'],
    'translator' => 'Yii::t',
    'sort' => false,
    'removeUnused' => false,
    'only' => ['*.php'],
    'except' => [
        '.svn',
        '.git',
        '.gitignore',
        '.gitkeep',
        '.hgignore',
        '.hgkeep',
        '/assets',
        '/commands',
        '/config',
        '/messages',
        '/migrations',
        '/runtime',
        '/tests'
    ],
    'format' => 'php',
    'messagePath' => dirname(__DIR__, 2) . '/common/messages',
    'overwrite' => true
];
