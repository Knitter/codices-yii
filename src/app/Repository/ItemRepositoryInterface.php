<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Repository;

use Codices\Model\Item;
use Codices\Query\ItemFilter;
use Codices\Query\ItemSearchResult;

interface ItemRepositoryInterface {

    public function findById(int $id): ?Item;

    public function save(Item $item): bool;

    public function delete(Item $item): bool;

    public function search(ItemFilter $filter): ItemSearchResult;

    /** @param int[] $authorIds */
    public function replaceAuthors(int $itemId, array $authorIds): void;

    /** @param int[] $genreIds */
    public function replaceGenres(int $itemId, array $genreIds): void;
}
