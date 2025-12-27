<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\View\Facade;

use Codices\Model\Account;
use yii\base\Model;

final class ProfileForm extends Model {

    public ?int $id = null;
    public string $username = '';
    public string $email = '';
    public string $name = '';

    public function rules(): array {
        return [
            [['username', 'email', 'name'], 'required'],
            [['username', 'email', 'name'], 'string', 'max' => 255],
            [['email'], 'email'],
        ];
    }

    public function attributeLabels(): array {
        return \Codices\View\Helper\Account::attributeLabels();
    }

    public function loadFromAccount(Account $account): void {
        $this->id = (int)$account->id;
        $this->username = (string)$account->username;
        $this->email = (string)$account->email;
        $this->name = (string)$account->name;
    }

    public function applyToAccount(Account $account): Account {
        $account->username = $this->username;
        $account->email = $this->email;
        $account->name = $this->name;
        return $account;
    }
}
