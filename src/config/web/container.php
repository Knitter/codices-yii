<?php

declare(strict_types=1);

use Codices\Repository\ItemRepository;
use Codices\Repository\ItemRepositoryInterface;
use Codices\Repository\GenreRepository;
use Codices\Repository\GenreRepositoryInterface;
use Codices\Repository\PublisherRepository;
use Codices\Repository\PublisherRepositoryInterface;
use Codices\Repository\SeriesRepository;
use Codices\Repository\SeriesRepositoryInterface;
use Codices\Repository\CollectionRepository;
use Codices\Repository\CollectionRepositoryInterface;
use Codices\Repository\AuthorRepository;
use Codices\Repository\AuthorRepositoryInterface;
use Codices\Repository\FormatRepository;
use Codices\Repository\FormatRepositoryInterface;
use Codices\Service\SearchService;
use Codices\Service\ItemService;
use Codices\Service\GenreService;
use Codices\Service\PublisherService;
use Codices\Service\SeriesService;
use Codices\Service\CollectionService;
use Codices\Service\AuthorService;
use Codices\Service\FormatService;

return [
    'definitions' => [
        // Repositories
        ItemRepositoryInterface::class => ItemRepository::class,
        GenreRepositoryInterface::class => GenreRepository::class,
        PublisherRepositoryInterface::class => PublisherRepository::class,
        SeriesRepositoryInterface::class => SeriesRepository::class,
        CollectionRepositoryInterface::class => CollectionRepository::class,
        AuthorRepositoryInterface::class => AuthorRepository::class,
        FormatRepositoryInterface::class => FormatRepository::class,

        // Services
        SearchService::class => SearchService::class,
        ItemService::class => ItemService::class,
        GenreService::class => GenreService::class,
        PublisherService::class => PublisherService::class,
        SeriesService::class => SeriesService::class,
        CollectionService::class => CollectionService::class,
        AuthorService::class => AuthorService::class,
        FormatService::class => FormatService::class,
    ],
];
