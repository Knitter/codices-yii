<?php

declare(strict_types=1);

namespace App\Model;

use Yiisoft\ActiveRecord\ActiveQueryInterface;
use Yiisoft\ActiveRecord\ActiveRecord;
use Yiisoft\Security\PasswordHasher;
use Yiisoft\Security\Random;

/**
 * Account model
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $name
 * @property bool $active
 * @property string $password
 * @property int $createdOn
 * @property int $updatedOn
 * @property string|null $authKey
 *
 * @since 2025.1
 */
final class Account extends ActiveRecord {

    public function tableName(): string {
        return 'account';
    }

    public function rules(): array {
        return [
            'username' => [['required'], ['string', 'max' => 255], ['unique']],
            'email' => [['required'], ['string', 'max' => 255], ['email']],
            'name' => [['required'], ['string', 'max' => 255]],
            'active' => [['boolean']],
            'password' => [['required'], ['string', 'min' => 6]],
            'createdOn' => [['integer']],
            'updatedOn' => [['integer']],
            'authKey' => [['string', 'max' => 255]],
        ];
    }

    public function beforeSave(bool $insert): bool {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->createdOn = time();
            }
            $this->updatedOn = time();
            if ($this->isAttributeChanged('password')) {
                $this->password = new PasswordHasher()->hash($this->password);
            }

            return true;
        }

        return false;
    }

    public function validatePassword(string $password): bool {
        return new PasswordHasher()->validate($password, $this->password);
    }

    public function generateAuthKey(): void {
        $this->authKey = Random::string(32);
    }

    // Relationships
    public function getPublishers(): ActiveQueryInterface {
        return $this->hasMany(Publisher::class, ['ownedById' => 'id']);
    }

    public function getSeries(): ActiveQueryInterface {
        return $this->hasMany(Series::class, ['ownedById' => 'id']);
    }

    public function getCollections(): ActiveQueryInterface {
        return $this->hasMany(Collection::class, ['ownedById' => 'id']);
    }

    public function getAuthors(): ActiveQueryInterface {
        return $this->hasMany(Author::class, ['ownedById' => 'id']);
    }

    public function getGenres(): ActiveQueryInterface {
        return $this->hasMany(Genre::class, ['ownedById' => 'id']);
    }

    public function getFormats(): ActiveQueryInterface {
        return $this->hasMany(Format::class, ['ownedById' => 'id']);
    }

    public function getItems(): ActiveQueryInterface {
        return $this->hasMany(Item::class, ['ownedById' => 'id']);
    }
}
