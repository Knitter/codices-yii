<?php

declare(strict_types=1);

use Codices\Repository\ItemRepository;
use Codices\Repository\ItemRepositoryInterface;
use Codices\Service\SearchService;
use Codices\Service\ItemService;

return [
    'definitions' => [
        // Repositories
        ItemRepositoryInterface::class => ItemRepository::class,

        // Services
        SearchService::class => SearchService::class,
        ItemService::class => ItemService::class,
    ],
];
