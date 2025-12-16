<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Service;

use Codices\Query\ItemFilter;
use Codices\Query\ItemSearchResult;
use Codices\Repository\ItemRepositoryInterface;

final class SearchService {

    public function __construct(private readonly ItemRepositoryInterface $items) {
    }

    public function searchItems(ItemFilter $filter): ItemSearchResult {
        return $this->items->search($filter);
    }
}
