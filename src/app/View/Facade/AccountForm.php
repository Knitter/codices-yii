<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\View\Facade;

use Codices\Model\Account;
use Yii;
use yii\base\Model;

final class AccountForm extends Model {

    public ?int $id = null;
    public string $username = '';
    public string $email = '';
    public string $name = '';
    public bool $active = true;
    public string $password = '';
    public string $confirmPassword = '';

    public function rules(): array {
        return [
            [['username', 'email', 'name'], 'required'],
            [['username', 'email', 'name'], 'string', 'max' => 255],
            ['email', 'email'],
            ['active', 'boolean'],

            // Password required on create (id is null)
            ['password', 'required', 'when' => function () { return $this->id === null; }],
            // Minimum length when provided
            ['password', 'string', 'min' => 6],
            // Confirm password matches when password provided
            ['confirmPassword', 'compare', 'compareAttribute' => 'password', 'skipOnEmpty' => true],
        ];
    }

    public function attributeLabels(): array {
        //TODO: Extract to UI/templating layer and avoid the hard dependency on Yii
        return [
            'id' => Yii::t('codices', 'No.'),
            'username' => Yii::t('codices', 'Username'),
            'email' => Yii::t('codices', 'Email'),
            'name' => Yii::t('codices', 'Name'),
            'active' => Yii::t('codices', 'Active'),
            'password' => Yii::t('codices', 'Password'),
            'confirmPassword' => Yii::t('codices', 'Confirm password'),
        ];
    }

    public function loadFromAccount(Account $account): void {
        $this->id = (int)$account->id;
        $this->username = (string)$account->username;
        $this->email = (string)$account->email;
        $this->name = (string)$account->name;
        $this->active = (bool)$account->active;
        $this->password = '';
        $this->confirmPassword = '';
    }

    public function applyToAccount(Account $account): Account {
        $account->id = $this->id;
        $account->username = $this->username;
        $account->email = $this->email;
        $account->name = $this->name;
        $account->active = $this->active ? 1 : 0;
        if ($this->password !== '') {
            // Assign plain password; AR will hash on save in beforeSave()
            $account->password = $this->password;
        }
        return $account;
    }
}
