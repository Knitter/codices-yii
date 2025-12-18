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

    public function listPage(int $page = 1, int $pageSize = 10, string $sort = 'name', string $direction = 'asc'): array {
        $allowedSort = ['name' => 'name', 'id' => 'id'];
        $sortBy = $allowedSort[$sort] ?? 'name';
        $sortDirection = strtolower($direction) === 'desc' ? SORT_DESC : SORT_ASC;

        $q = Collection::find();

        $countQuery = clone $q;
        $total = (int)$countQuery->select(new Expression('COUNT(*)'))->scalar();

        $items = $q->orderBy([$sortBy => $sortDirection])
            ->offset(max(0, ($page - 1) * $pageSize))
            ->limit($pageSize)
            ->all();

        return [
            'items' => $items,
            'total' => $total,
            'page' => $page,
            'pageSize' => $pageSize,
        ];
    }

    public function search(CollectionFilter $filter): CollectionListResult {
        $allowedSort = ['name' => 'name', 'id' => 'id'];
        $sortBy = $allowedSort[$filter->sort] ?? 'name';
        $sortDirection = strtolower($filter->direction) === 'desc' ? SORT_DESC : SORT_ASC;

        $q = Collection::find();
        if ($filter->name !== null) {
            $q->andWhere(['like', 'name', $filter->name]);
        }

        $countQuery = clone $q;
        $total = (int)$countQuery->select(new Expression('COUNT(*)'))->scalar();

        $items = $q->orderBy([$sortBy => $sortDirection])
            ->offset(max(0, ($filter->page - 1) * $filter->pageSize))
            ->limit($filter->pageSize)
            ->all();

        return new CollectionListResult($items, $total, $filter->page, $filter->pageSize);
    }
}
