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

    /**
     * Searches accounts based on the criteria specified in the provided filter.
     *
     * @param AccountFilter $filter The criteria for filtering, sorting, and pagination.
     * @return AccountListResult A result object containing the filtered and paginated account list along with the total count.
     */
    public function search(AccountFilter $filter): AccountListResult {
        $allowedSort = ['id' => 'id', 'username' => 'username', 'email' => 'email', 'name' => 'name'];
        $sortBy = $allowedSort[$filter->sort] ?? 'username';
        $sortDirection = strtolower($filter->direction) === 'desc' ? SORT_DESC : SORT_ASC;
        $offset = max(0, ($filter->page - 1) * $filter->pageSize);

        $q = Account::find()
            ->andFilterWhere(['like', 'username', $filter->username])
            ->andFilterWhere(['like', 'email', $filter->email])
            ->andFilterWhere(['like', 'name', $filter->name])
            ->andFilterWhere(['active' => $filter->active]);

        $countQuery = clone $q;
        $total = (int)$countQuery->select(new Expression('COUNT(id)'))->scalar();

        $items = $q->orderBy([$sortBy => $sortDirection])
            ->offset($offset)
            ->limit($filter->pageSize)
            ->all();

        return new AccountListResult($items, $total, $filter->page, $filter->pageSize);
    }
}
