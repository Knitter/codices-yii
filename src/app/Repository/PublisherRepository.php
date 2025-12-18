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
use yii\db\Exception;
use yii\db\Expression;
use yii\db\StaleObjectException;

final class PublisherRepository implements PublisherRepositoryInterface {

    public function findById(int $id): ?Publisher {
        return Publisher::findOne($id);
    }

    /**
     * @throws Exception
     */
    public function save(Publisher $publisher): bool {
        return (bool)$publisher->save();
    }

    /**
     * @throws StaleObjectException
     * @throws \Throwable
     */
    public function delete(Publisher $publisher): bool {
        return (bool)$publisher->delete();
    }

    public function listPage(int $page = 1, int $pageSize = 10, string $sort = 'name', string $direction = 'asc'): array {
        $allowedSort = ['name' => 'name', 'id' => 'id'];
        $sortBy = $allowedSort[$sort] ?? 'name';
        $sortDirection = strtolower($direction) === 'desc' ? SORT_DESC : SORT_ASC;

        $q = Publisher::find();

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

    public function search(PublisherFilter $filter): PublisherListResult {
        $allowedSort = ['name' => 'name', 'id' => 'id'];
        $sortBy = $allowedSort[$filter->sort] ?? 'name';
        $sortDirection = strtolower($filter->direction) === 'desc' ? SORT_DESC : SORT_ASC;

        $q = Publisher::find();
        if ($filter->name !== null) {
            $q->andWhere(['like', 'name', $filter->name]);
        }

        $countQuery = clone $q;
        $total = (int)$countQuery->select(new Expression('COUNT(*)'))->scalar();

        $items = $q->orderBy([$sortBy => $sortDirection])
            ->offset(max(0, ($filter->page - 1) * $filter->pageSize))
            ->limit($filter->pageSize)
            ->all();

        return new PublisherListResult($items, $total, $filter->page, $filter->pageSize);
    }
}
