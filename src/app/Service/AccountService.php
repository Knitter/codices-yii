<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Service;

use Codices\Model\Account;
use Codices\Query\AccountFilter;
use Codices\Query\AccountListResult;
use Codices\Repository\AccountRepositoryInterface;
use RuntimeException;
use yii\base\Exception;

final readonly class AccountService {

    public function __construct(private AccountRepositoryInterface $accounts) {
    }

    public function search(AccountFilter $filter): AccountListResult {
        return $this->accounts->search($filter);
    }

    public function findById(int $id): ?Account {
        return $this->accounts->findById($id);
    }

    /**
     * @throws Exception
     */
    public function create(Account $form): Account {
        $account = new Account();
        $form->applyToAccount($account);
        if (empty($account->authKey)) {
            $account->generateAuthKey();
        }

        if (!$this->accounts->save($account)) {
            throw new RuntimeException('Failed to save account');
        }
        return $account;
    }

    public function update(int $id, Account $form): Account {
        $account = $this->accounts->findById($id);
        if ($account === null) {
            throw new RuntimeException('Account not found');
        }

        $form->applyToAccount($account);
        if (!$this->accounts->save($account)) {
            throw new RuntimeException('Failed to save account');
        }
        return $account;
    }

    public function delete(int $id): void {
        $account = $this->accounts->findById($id);
        if ($account === null) {
            return;
        }
        $this->accounts->delete($account);
    }
}
