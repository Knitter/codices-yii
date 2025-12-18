<?php

declare(strict_types=1);

namespace Codices\View\Facade;

use Codices\Model\Account;
use Codices\Security\CodicesIdentity;
use Yii;
use yii\base\Model;

final class LoginForm extends Model {

    public string $usernameOrEmail = '';
    public string $password = '';
    public bool $rememberMe = true;

    private ?Account $account = null;

    public function rules(): array {
        return [
            [['usernameOrEmail', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validateCredentials'],
        ];
    }

    public function attributeLabels(): array {
        return [
            'usernameOrEmail' => 'Username or Email',
            'password' => 'Password',
            'rememberMe' => 'Remember me',
        ];
    }

    public function validateCredentials(): void {
        if ($this->hasErrors()) {
            return;
        }
        $acc = $this->resolveAccount();
        if ($acc === null || !$acc->validatePassword($this->password)) {
            $this->addError('password', 'Invalid username/email or password.');
        }
    }

    public function login(): bool {
        if (!$this->validate()) {
            return false;
        }
        $acc = $this->resolveAccount();
        if ($acc === null) {
            return false;
        }
        $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
        return Yii::$app->user->login(CodicesIdentity::fromAccount($acc), $duration);
    }

    public function getAccount(): ?Account {
        return $this->resolveAccount();
    }

    private function resolveAccount(): ?Account {
        if ($this->account !== null) {
            return $this->account;
        }
        $u = trim($this->usernameOrEmail);
        if ($u === '') {
            return null;
        }
        // prefer username match; fallback to email
        $acc = Account::find()->where(['username' => $u, 'active' => 1])->one();
        if ($acc === null) {
            $acc = Account::find()->where(['email' => $u, 'active' => 1])->one();
        }
        $this->account = $acc instanceof Account ? $acc : null;
        return $this->account;
    }
}
