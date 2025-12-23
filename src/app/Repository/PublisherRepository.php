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

    /**
     * Searches for publishers based on the provided filter criteria, applies sorting,
     * pagination, and retrieves a list of matching publisher records along with the total count.
     *
     * @param PublisherFilter $filter The filter containing search criteria, sorting preferences,
     *                                 and pagination details.
     * @return PublisherListResult A result object containing the list of publishers,
     *                              total count of matched records, current page, and page size.
     */
    public function search(PublisherFilter $filter): PublisherListResult {
        $allowedSort = ['name' => 'name', 'id' => 'id'];
        $sortBy = $allowedSort[$filter->sort] ?? 'name';
        $sortDirection = strtolower($filter->direction) === 'desc' ? SORT_DESC : SORT_ASC;
        $offset = max(0, ($filter->page - 1) * $filter->pageSize);

        $q = Publisher::find()
            ->andFilterWhere(['like', 'name', $filter->name]);

        $countQuery = clone $q;
        $total = (int)$countQuery->select(new Expression('COUNT(id)'))->scalar();

        $items = $q->orderBy([$sortBy => $sortDirection])
            ->offset($offset)
            ->limit($filter->pageSize)
            ->all();

        return new PublisherListResult($items, $total, $filter->page, $filter->pageSize);
    }
}
