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
 * @property int $authorId
 */
final class ItemAuthor extends ActiveRecord {

    public static function tableName(): string {
        return 'item_author';
    }

    public static function primaryKey(): array {
        return ['itemId', 'authorId'];
    }

    // Relationships
    public function getItem(): ActiveQuery {
        return $this->hasOne(Item::class, ['id' => 'itemId']);
    }

    public function getAuthor(): ActiveQuery {
        return $this->hasOne(Author::class, ['id' => 'authorId']);
    }
}
