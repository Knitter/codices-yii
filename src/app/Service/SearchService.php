<?php

declare(strict_types=1);

namespace Codices\Service;

use Codices\Query\ItemFilter;
use Codices\Query\ItemSearchResult;
use Codices\Repository\ItemRepositoryInterface;

final class SearchService
{
    public function __construct(private readonly ItemRepositoryInterface $items)
    {
    }

    public function searchItems(ItemFilter $filter): ItemSearchResult
    {
        return $this->items->search($filter);
    }
}
