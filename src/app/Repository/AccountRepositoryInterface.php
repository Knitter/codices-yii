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

interface AccountRepositoryInterface {

    public function findById(int $id): ?Account;

    public function save(Account $account): bool;

    public function delete(Account $account): bool;

    /**
     * @return array{items: Account[], total: int, page: int, pageSize: int}
     */
    public function listPage(int $page = 1, int $pageSize = 10, string $sort = 'username', string $direction = 'asc'): array;

    public function search(AccountFilter $filter): AccountListResult;
}
