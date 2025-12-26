<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Repository;

use Codices\Model\Series;
use Codices\Query\SeriesFilter;
use Codices\Query\SeriesListResult;
use yii\db\Exception;
use yii\db\Expression;
use yii\db\StaleObjectException;

final class SeriesRepository implements SeriesRepositoryInterface {

    public function findById(int $id): ?Series {
        return Series::findOne($id);
    }

    /**
     * @throws Exception
     */
    public function save(Series $series): bool {
        return (bool)$series->save();
    }

    /**
     * @throws StaleObjectException
     * @throws \Throwable
     */
    public function delete(Series $series): bool {
        return (bool)$series->delete();
    }

    /**
     * Searches and retrieves a list of series based on the provided filter criteria.
     *
     * @param SeriesFilter $filter The filter criteria containing sorting options, pagination details, and search term.
     * @return SeriesListResult The result object containing the filtered and sorted list of series, total count, current page, and page size.
     */
    public function search(SeriesFilter $filter): SeriesListResult {
        $allowedSort = ['name' => 'name', 'id' => 'id'];
        $sortBy = $allowedSort[$filter->sort] ?? 'name';
        $sortDirection = strtolower($filter->direction) === 'desc' ? SORT_DESC : SORT_ASC;
        $offset = max(0, ($filter->page - 1) * $filter->pageSize);

        $q = Series::find()
            ->andFilterWhere(['id' => $filter->id])
            ->andFilterWhere(['like', 'name', $filter->name]);

        $countQuery = clone $q;
        $total = (int)$countQuery->select(new Expression('COUNT(*)'))->scalar();

        $items = $q->orderBy([$sortBy => $sortDirection])
            ->offset($offset)
            ->limit($filter->pageSize)
            ->all();

        return new SeriesListResult($items, $total, $filter->page, $filter->pageSize);
    }
}
