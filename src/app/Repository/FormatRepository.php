<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Repository;

use Codices\Model\Format;
use Codices\Query\FormatFilter;
use Codices\Query\FormatListResult;
use yii\db\Exception;
use yii\db\Expression;
use yii\db\StaleObjectException;

final class FormatRepository implements FormatRepositoryInterface {

    public function findOne(string $type, string $name, int $ownedById): ?Format {
        return Format::findOne(['type' => $type, 'name' => $name, 'ownedById' => $ownedById]);
    }

    /**
     * @throws Exception
     */
    public function save(Format $format): bool {
        return (bool)$format->save();
    }

    /**
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function delete(Format $format): bool {
        return (bool)$format->delete();
    }

    /**
     * Searches and retrieves a paginated list of formats based on the provided filter criteria.
     *
     * @param FormatFilter $filter The filter object which defines the search criteria, sorting, and pagination details.
     * @return FormatListResult A list result object containing the filtered and sorted formats, total count, current page, and page size.
     */
    public function search(FormatFilter $filter): FormatListResult {
        $allowedSort = ['name' => 'name', 'type' => 'type'];
        $sortBy = $allowedSort[$filter->sort] ?? 'name';
        $sortDirection = strtolower($filter->direction) === 'desc' ? SORT_DESC : SORT_ASC;
        $offset = max(0, ($filter->page - 1) * $filter->pageSize);

        $q = Format::find()
            ->andFilterWhere(['type' => $filter->type])
            ->andFilterWhere(['like', 'name', $filter->name]);

        $countQuery = clone $q;
        $total = (int)$countQuery->select(new Expression('COUNT(*)'))->scalar();

        $items = $q->orderBy([$sortBy => $sortDirection, 'name' => SORT_ASC])
            ->offset($offset)
            ->limit($filter->pageSize)
            ->all();

        return new FormatListResult($items, $total, $filter->page, $filter->pageSize);
    }
}
