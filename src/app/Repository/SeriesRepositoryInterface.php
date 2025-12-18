<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Repository;

use Codices\Model\Series;
use Codices\Query\SeriesFilter;
use Codices\Query\SeriesListResult;

interface SeriesRepositoryInterface {

    public function findById(int $id): ?Series;

    public function save(Series $series): bool;

    public function delete(Series $series): bool;

    /**
     * @return array{items: Series[], total: int, page: int, pageSize: int}
     */
    public function listPage(int $page = 1, int $pageSize = 10, string $sort = 'name', string $direction = 'asc'): array;

    public function search(SeriesFilter $filter): SeriesListResult;
}
