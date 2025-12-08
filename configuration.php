<?php

declare(strict_types=1);

return [
    'config-plugin' => [
        'params' => 'common/params.php',
        'params-web' => [
            '$params',
            'web/params.php',
        ],
        'params-console' => [
            '$params',
            'console/params.php',
        ],
        'di' => 'common/di/*.php',
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
        'routes' => 'common/routes.php',
        'bootstrap' => [
            'common/bootstrap.php',
        ],
        'bootstrap-web' => '$bootstrap',
        'bootstrap-console' => '$bootstrap',
    ],
    'config-plugin-options' => [
        'source-directory' => 'config',
    ],
    'config-plugin-environments' => [
        'dev' => [
            'params' => [
                'envs/dev/params.php',
            ],
        ],
        'prod' => [
            'params' => [
                'envs/prod/params.php',
            ],
        ],
        'test' => [
            'params' => [
                'envs/test/params.php',
            ],
        ],
    ],
];
