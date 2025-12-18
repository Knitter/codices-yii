<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Repository;

use Codices\Model\Publisher;
use Codices\Query\PublisherFilter;
use Codices\Query\PublisherListResult;

interface PublisherRepositoryInterface {

    public function findById(int $id): ?Publisher;

    public function save(Publisher $publisher): bool;

    public function delete(Publisher $publisher): bool;

    /**
     * @return array{items: Publisher[], total: int, page: int, pageSize: int}
     */
    public function listPage(int $page = 1, int $pageSize = 10, string $sort = 'name', string $direction = 'asc'): array;

    public function search(PublisherFilter $filter): PublisherListResult;
}
