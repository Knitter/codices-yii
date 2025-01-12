<?php

declare(strict_types=1);

return [
    'config-plugin' => [
        'params' => 'core/params.php',
        'params-web' => [
            '$params',
            'web/params.php',
        ],
        'params-console' => [
            '$params',
            'console/params.php',
        ],
        'di' => 'core/di/*.php',
        'di-web' => [
            '$di',
            'web/di/*.php',
        ],
        'di-console' => '$di',
        'di-providers' => [],
        'di-providers-web' => [
            '$di-providers',
        ],
        'di-providers-console' => [
            '$di-providers',
        ],
        'events' => [],
        'events-web' => [
            '$events',
            'web/events.php',
        ],
        'events-console' => '$events',
        'routes' => 'core/routes.php',
        'bootstrap' => [],
        'bootstrap-web' => '$bootstrap',
        'bootstrap-console' => '$bootstrap',
    ],
    'config-plugin-environments' => [
        'dev' => [
            'params' => [
                'environments/dev/params.php',
            ],
        ],
        'prod' => [
            'params' => [
                'environments/prod/params.php',
            ],
        ],
        'test' => [
            'params' => [
                'environments/test/params.php',
            ],
        ],
    ],
    'config-plugin-options' => [
        'source-directory' => 'config',
    ],
];
