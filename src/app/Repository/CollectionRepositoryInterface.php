<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Repository;

use Codices\Model\Collection;

interface CollectionRepositoryInterface {

    public function findById(int $id): ?Collection;

    public function save(Collection $collection): bool;

    public function delete(Collection $collection): bool;

    /**
     * @return array{items: Collection[], total: int, page: int, pageSize: int}
     */
    public function listPage(int $page = 1, int $pageSize = 10, string $sort = 'name', string $direction = 'asc'): array;
}
