<?php

declare(strict_types=1);

namespace Codices\Query;

use Codices\Model\Item;

final class ItemSearchResult
{
    /** @param Item[] $items */
    public function __construct(
        public readonly array $items,
        public readonly int $total,
        public readonly int $page,
        public readonly int $pageSize,
    ) {
    }
}
