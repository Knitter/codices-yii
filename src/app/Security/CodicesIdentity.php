<?php

declare(strict_types=1);

namespace Codices\Security;

use Codices\Model\Account;
use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

final class CodicesIdentity implements IdentityInterface {

    public function __construct(private readonly Account $account) {}

    public static function fromAccount(Account $account): self {
        return new self($account);
    }

    public function getAccount(): Account {
        return $this->account;
    }

    // IdentityInterface
    public static function findIdentity($id): ?IdentityInterface {
        $acc = Account::findOne(['id' => (int)$id, 'active' => 1]);
        return $acc instanceof Account ? new self($acc) : null;
    }

    public static function findIdentityByAccessToken($token, $type = null): IdentityInterface {
        throw new NotSupportedException('Access token authentication is not supported.');
    }

    public function getId(): int|string|null {
        return $this->account->id;
    }

    public function getAuthKey(): ?string {
        return $this->account->authKey;
    }

    public function validateAuthKey($authKey): bool {
        return $this->account->authKey === $authKey;
    }
}
