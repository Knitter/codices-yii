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

        // Services (SearchService has a typed constructor and will be auto-resolved)
        SearchService::class => SearchService::class,
        ItemService::class => ItemService::class,
    ],
];
