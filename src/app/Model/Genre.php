<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Model;

use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $name
 * @property int $ownedById
 */
final class Genre extends ActiveRecord {

    public static function tableName(): string {
        return 'genre';
    }

    public function rules(): array {
        return [
            'name' => [['required'], ['string', 'max' => 255]],
            'ownedById' => [['required'], ['integer'], ['exist', 'targetClass' => Account::class, 'targetAttribute' => 'id']],
        ];
    }

    // Relationships
    public function getOwner(): ActiveQuery {
        return $this->hasOne(Account::class, ['id' => 'ownedById']);
    }

    /**
     * @throws InvalidConfigException
     */
    public function getItems(): ActiveQuery {
        return $this->hasMany(Item::class, ['id' => 'itemId'])
            ->viaTable('item_genre', ['genreId' => 'id']);
    }

    public function getItemGenres(): ActiveQuery {
        return $this->hasMany(ItemGenre::class, ['genreId' => 'id']);
    }
}
