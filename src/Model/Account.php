<?php

declare(strict_types=1);

namespace App\Model;

use Yiisoft\ActiveRecord\ActiveRecord;
use Yiisoft\Security\PasswordHasher;

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
                $this->password = (new PasswordHasher())->hash($this->password);
            }

            return true;
        }

        return false;
    }

    public function validatePassword(string $password): bool {
        return (new PasswordHasher())->validate($password, $this->password);
    }

    public function generateAuthKey(): void {
        $this->authKey = \Yiisoft\Security\Random::string(32);
    }

    // Relationships
    public function getPublishers() {
        return $this->hasMany(Publisher::class, ['ownedById' => 'id']);
    }

    public function getSeries() {
        return $this->hasMany(Series::class, ['ownedById' => 'id']);
    }

    public function getCollections() {
        return $this->hasMany(Collection::class, ['ownedById' => 'id']);
    }

    public function getAuthors() {
        return $this->hasMany(Author::class, ['ownedById' => 'id']);
    }

    public function getGenres() {
        return $this->hasMany(Genre::class, ['ownedById' => 'id']);
    }

    public function getFormats() {
        return $this->hasMany(Format::class, ['ownedById' => 'id']);
    }

    public function getItems() {
        return $this->hasMany(Item::class, ['ownedById' => 'id']);
    }
}
