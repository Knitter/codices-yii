<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Repository;

use Codices\Model\Format;
use yii\db\Exception;
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

    public function listPage(int $page = 1, int $pageSize = 10, string $sort = 'name', string $direction = 'asc'): array {
        $page = max(1, $page);
        $pageSize = max(1, $pageSize);
        $offset = ($page - 1) * $pageSize;

        $allowedSort = ['type', 'name'];
        $sortBy = in_array($sort, $allowedSort, true) ? $sort : 'name';
        $dir = strtolower($direction) === 'desc' ? SORT_DESC : SORT_ASC;

        $query = Format::find();
        $total = (int)$query->count('*');

        $items = $query
            ->orderBy([$sortBy => $dir, 'name' => SORT_ASC])
            ->offset($offset)
            ->limit($pageSize)
            ->all();

        /** @var Format[] $items */
        return [
            'items' => $items,
            'total' => $total,
            'page' => $page,
            'pageSize' => $pageSize,
        ];
    }
}
