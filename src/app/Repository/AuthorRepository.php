<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Repository;

use Codices\Model\Author;
use Codices\Query\AuthorFilter;
use Codices\Query\AuthorListResult;
use yii\db\Expression;
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

    public function list(int $page = 1, int $pageSize = 10, string $sort = 'name', string $direction = 'asc'): array {
        $q = Author::find();

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

    /**
     * Searches for authors based on the provided filter criteria. Supports sorting, filtering, and pagination.
     *
     * @param AuthorFilter $filter An object containing the filtering criteria, such as name, sorting options,
     *                             page number, and page size.
     * @return AuthorListResult Returns an object containing the list of authors that match the criteria,
     *                          the total count of matching authors, and pagination information.
     */
    public function search(AuthorFilter $filter): AuthorListResult {
        $allowedSort = ['name' => 'name', 'id' => 'id'];
        $sortBy = $allowedSort[$filter->sort] ?? 'name';
        $sortDirection = strtolower($filter->direction) === 'desc' ? SORT_DESC : SORT_ASC;
        $offset = max(0, ($filter->page - 1) * $filter->pageSize);

        $q = Author::find()
            ->andFilterWhere(['or',
                ['like', 'name', $filter->name],
                ['like', 'surname', $filter->name],
            ]);

        $countQuery = clone $q;
        $total = (int)$countQuery->select(new Expression('COUNT(*)'))->scalar();

        $items = $q->orderBy([$sortBy => $sortDirection])
            ->offset($offset)
            ->limit($filter->pageSize)
            ->all();

        return new AuthorListResult($items, $total, $filter->page, $filter->pageSize);
    }
}
