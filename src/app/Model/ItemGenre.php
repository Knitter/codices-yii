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
 * @property int $itemId
 * @property int $genreId
 */
final class ItemGenre extends ActiveRecord {

    public static function tableName(): string {
        return 'item_genre';
    }

    public static function primaryKey(): array {
        return ['itemId', 'genreId'];
    }

    public function rules(): array {
        return [
            'itemId' => [['required'], ['integer'], ['exist', 'targetClass' => Item::class, 'targetAttribute' => 'id']],
            'genreId' => [['required'], ['integer'], ['exist', 'targetClass' => Genre::class, 'targetAttribute' => 'id']],
        ];
    }

    // Relationships
    public function getItem(): ActiveQuery {
        return $this->hasOne(Item::class, ['id' => 'itemId']);
    }

    public function getGenre(): ActiveQuery {
        return $this->hasOne(Genre::class, ['id' => 'genreId']);
    }
}
