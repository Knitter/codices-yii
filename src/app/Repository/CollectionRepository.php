<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Repository;

use Codices\Model\Collection;
use Codices\Query\CollectionFilter;
use Codices\Query\CollectionListResult;
use yii\db\Exception;
use yii\db\Expression;
use yii\db\StaleObjectException;

final class CollectionRepository implements CollectionRepositoryInterface {

    public function findById(int $id): ?Collection {
        return Collection::findOne($id);
    }

    /**
     * @throws Exception
     */
    public function save(Collection $collection): bool {
        return (bool)$collection->save();
    }

    /**
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function delete(Collection $collection): bool {
        return (bool)$collection->delete();
    }

    /**
     * Searches for collections based on the provided filter criteria.
     *
     * @param CollectionFilter $filter The filter criteria including sorting, pagination,
     *                                  and optional name filtering for the search.
     * @return CollectionListResult The result of the search, containing the matched items,
     *                               total count, current page, and page size.
     */
    public function search(CollectionFilter $filter): CollectionListResult {
        $allowedSort = ['name' => 'name', 'id' => 'id'];
        $sortBy = $allowedSort[$filter->sort] ?? 'name';
        $sortDirection = strtolower($filter->direction) === 'desc' ? SORT_DESC : SORT_ASC;
        $offset = max(0, ($filter->page - 1) * $filter->pageSize);

        $q = Collection::find()
            ->andFilterWhere(['id' => $filter->id])
            ->andFilterWhere(['like', 'name', $filter->name]);

        $countQuery = clone $q;
        $total = (int)$countQuery->select(new Expression('COUNT(*)'))->scalar();

        $items = $q->orderBy([$sortBy => $sortDirection])
            ->offset($offset)
            ->limit($filter->pageSize)
            ->all();

        return new CollectionListResult($items, $total, $filter->page, $filter->pageSize);
    }
}
