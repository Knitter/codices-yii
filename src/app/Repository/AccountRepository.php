<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Repository;

use Codices\Model\Account;
use Codices\Query\AccountFilter;
use Codices\Query\AccountListResult;
use yii\db\Exception;
use yii\db\Expression;
use yii\db\StaleObjectException;

final class AccountRepository implements AccountRepositoryInterface {

    public function findById(int $id): ?Account {
        return Account::findOne($id);
    }

    /**
     * @throws Exception
     */
    public function save(Account $account): bool {
        return (bool)$account->save();
    }

    /**
     * @throws StaleObjectException
     * @throws \Throwable
     */
    public function delete(Account $account): bool {
        return (bool)$account->delete();
    }

    public function listPage(int $page = 1, int $pageSize = 10, string $sort = 'username', string $direction = 'asc'): array {
        $allowedSort = ['id' => 'id', 'username' => 'username', 'email' => 'email', 'name' => 'name'];
        $sortBy = $allowedSort[$sort] ?? 'username';
        $sortDirection = strtolower($direction) === 'desc' ? SORT_DESC : SORT_ASC;

        $q = Account::find();

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

    public function search(AccountFilter $filter): AccountListResult {
        $allowedSort = ['id' => 'id', 'username' => 'username', 'email' => 'email', 'name' => 'name'];
        $sortBy = $allowedSort[$filter->sort] ?? 'username';
        $sortDirection = strtolower($filter->direction) === 'desc' ? SORT_DESC : SORT_ASC;

        $q = Account::find();
        if ($filter->username !== null) {
            $q->andWhere(['like', 'username', $filter->username]);
        }
        if ($filter->email !== null) {
            $q->andWhere(['like', 'email', $filter->email]);
        }
        if ($filter->name !== null) {
            $q->andWhere(['like', 'name', $filter->name]);
        }
        if ($filter->active !== null) {
            $q->andWhere(['active' => $filter->active]);
        }

        $countQuery = clone $q;
        $total = (int)$countQuery->select(new Expression('COUNT(*)'))->scalar();

        $items = $q->orderBy([$sortBy => $sortDirection])
            ->offset(max(0, ($filter->page - 1) * $filter->pageSize))
            ->limit($filter->pageSize)
            ->all();

        return new AccountListResult($items, $total, $filter->page, $filter->pageSize);
    }
}
