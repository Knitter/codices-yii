<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Repository;

use Codices\Model\Author;
use yii\db\Exception;
use yii\db\StaleObjectException;

final class AuthorRepository implements AuthorRepositoryInterface {

    public function findById(int $id): ?Author {
        return Author::findOne($id);
    }

    /**
     * @throws Exception
     */
    public function save(Author $author): bool {
        return (bool)$author->save();
    }

    /**
     * @throws StaleObjectException
     * @throws \Throwable
     */
    public function delete(Author $author): bool {
        return (bool)$author->delete();
    }

    public function listPage(int $page = 1, int $pageSize = 10, string $sort = 'name', string $direction = 'asc'): array {
        $page = max(1, $page);
        $pageSize = max(1, $pageSize);
        $offset = ($page - 1) * $pageSize;

        $allowedSort = ['name', 'surname'];
        $sortBy = in_array($sort, $allowedSort, true) ? $sort : 'name';
        $dir = strtolower($direction) === 'desc' ? SORT_DESC : SORT_ASC;

        $query = Author::find();
        $total = (int)$query->count('*');

        $items = $query
            ->orderBy([$sortBy => $dir])
            ->offset($offset)
            ->limit($pageSize)
            ->all();

        /** @var Author[] $items */
        return [
            'items' => $items,
            'total' => $total,
            'page' => $page,
            'pageSize' => $pageSize,
        ];
    }
}
