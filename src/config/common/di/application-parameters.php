<?php

declare(strict_types=1);

use App\app\ApplicationParameters;

/** @var array $params */

return [
    ApplicationParameters::class => [
        'class' => ApplicationParameters::class,
        'charset()' => [$params['app']['charset']],
        'name()' => [$params['app']['name']],
    ],
];
