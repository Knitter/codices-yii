<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Repository;

use Codices\Model\Publisher;
use yii\db\Expression;

final class PublisherRepository implements PublisherRepositoryInterface {

    public function findById(int $id): ?Publisher {
        return Publisher::findOne($id);
    }

    public function save(Publisher $publisher): bool {
        return (bool)$publisher->save();
    }

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
}
