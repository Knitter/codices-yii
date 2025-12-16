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
 * @property string $name
 * @property int $ownedById
 * @property bool $completed
 * @property int|null $bookCount
 * @property int|null $ownedCount
 */
final class Series extends ActiveRecord {

    public static function tableName(): string {
        return 'series';
    }

    public function rules(): array {
        return [
            'name' => [['required'], ['string', 'max' => 255]],
            'ownedById' => [['required'], ['integer'], ['exist', 'targetClass' => Account::class, 'targetAttribute' => 'id']],
            'completed' => [['boolean']],
            'bookCount' => [['integer']],
            'ownedCount' => [['integer']],
        ];
    }

    // Relationships
    public function getOwner(): ActiveQuery {
        return $this->hasOne(Account::class, ['id' => 'ownedById']);
    }

    public function getItems(): ActiveQuery {
        return $this->hasMany(Item::class, ['seriesId' => 'id']);
    }
}
