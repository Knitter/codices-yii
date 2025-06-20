<?php

declare(strict_types=1);

use Yiisoft\ActiveRecord\ConnectionProviderMiddleware;
use Yiisoft\Db\Connection\ConnectionInterface;

return [
    ConnectionProviderMiddleware::class => [
        'class' => ConnectionProviderMiddleware::class,
        '__construct()' => [
            'db' => ConnectionInterface::class,
        ],
    ],
];
