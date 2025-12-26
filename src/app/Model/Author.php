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
 * @property string|null $surname
 * @property string|null $biography
 * @property string|null $website
 * @property string|null $photo
 */
final class Author extends ActiveRecord {

    public static function tableName(): string {
        return 'author';
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
            ->viaTable('item_author', ['authorId' => 'id']);
    }

    public function getItemAuthors(): ActiveQuery {
        return $this->hasMany(ItemAuthor::class, ['authorId' => 'id']);
    }

    public function getFullName(): string {
        return $this->surname ? "{$this->name} {$this->surname}" : $this->name;
    }
}
