<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Model;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
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

    public static function tableName(): string {
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

    public function beforeSave($insert): bool {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($insert) {
            $this->createdOn = time();
        }

        $this->updatedOn = time();
        //TODO: Fix hash password generation
        //if ($this->isAttributeChanged('password')) {
        //    $this->password = new PasswordHasher()->hash($this->password);
        //}

        return true;
    }

    public function validatePassword(string $password): bool {
        return false; //TODO: return new PasswordHasher()->validate($password, $this->password);
    }

    public function generateAuthKey(): void {
        //TODO: $this->authKey = Random::string(32);
    }

    // Relationships
    public function getPublishers(): ActiveQuery {
        return $this->hasMany(Publisher::class, ['ownedById' => 'id']);
    }

    public function getSeries(): ActiveQuery {
        return $this->hasMany(Series::class, ['ownedById' => 'id']);
    }

    public function getCollections(): ActiveQuery {
        return $this->hasMany(Collection::class, ['ownedById' => 'id']);
    }

    public function getAuthors(): ActiveQuery {
        return $this->hasMany(Author::class, ['ownedById' => 'id']);
    }

    public function getGenres(): ActiveQuery {
        return $this->hasMany(Genre::class, ['ownedById' => 'id']);
    }

    public function getFormats(): ActiveQuery {
        return $this->hasMany(Format::class, ['ownedById' => 'id']);
    }

    public function getItems(): ActiveQuery {
        return $this->hasMany(Item::class, ['ownedById' => 'id']);
    }
}
