<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Repository;

use Codices\Model\Genre;
use Codices\Query\GenreFilter;
use Codices\Query\GenreListResult;
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

    public function search(GenreFilter $filter): GenreListResult {
        $sort = ['name' => 'name', 'id' => 'id'];
        $sortBy = $sort[$filter->sort] ?? 'name';
        $sortDirection = strtolower($filter->direction) === 'desc' ? SORT_DESC : SORT_ASC;
        $offset = max(0, ($filter->page - 1) * $filter->pageSize);

        $q = Genre::find()
            ->andFilterWhere(['id' => $filter->id])
            ->andFilterWhere(['like', 'name', $filter->name]);

        $countQuery = clone $q;
        $total = (int)$countQuery->select(new Expression('COUNT(id)'))->scalar();

        $items = $q->orderBy([$sortBy => $sortDirection])
            ->offset($offset)
            ->limit($filter->pageSize)
            ->all();

        return new GenreListResult($items, $total, $filter->page, $filter->pageSize);
    }
}
