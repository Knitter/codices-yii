<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Repository;

use Codices\Model\Genre;
use yii\db\Exception;
use yii\db\Expression;
use yii\db\StaleObjectException;

final class GenreRepository implements GenreRepositoryInterface {

    public function findById(int $id): ?Genre {
        return Genre::findOne($id);
    }

    /**
     * @throws Exception
     */
    public function save(Genre $genre): bool {
        return (bool)$genre->save();
    }

    /**
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function delete(Genre $genre): bool {
        return (bool)$genre->delete();
    }

    public function listPage(int $page = 1, int $pageSize = 10, string $sort = 'name', string $direction = 'asc'): array {
        $q = Genre::find();

        $safeSorts = ['name' => 'name', 'id' => 'id'];
        $sortBy = $safeSorts[$sort] ?? 'name';
        $sortDirection = strtolower($direction) === 'desc' ? SORT_DESC : SORT_ASC;

        $countQuery = clone $q;
        $total = (int)$countQuery->select(new Expression('COUNT(*)'))->scalar();

        $offset = max(0, ($page - 1) * $pageSize);
        $items = $q->orderBy([$sortBy => $sortDirection])
            ->offset($offset)
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
