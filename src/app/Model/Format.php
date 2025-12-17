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
 * @property string $type
 * @property string $name
 * @property int $ownedById
 */
final class Format extends ActiveRecord {

    public static function tableName(): string {
        return 'format';
    }

    public static function primaryKey(): array {
        return ['type', 'name', 'ownedById'];
    }

    // Relationships
    public function getOwner(): ActiveQuery {
        return $this->hasOne(Account::class, ['id' => 'ownedById']);
    }

    public function getItems(): ActiveQuery {
        return $this->hasMany(Item::class, ['format' => 'name'])
            ->andWhere(['type' => $this->type]);
    }

    public static function getFormatTypes(): array {
        return [
            'paper' => 'Paper Book',
            'ebook' => 'E-Book',
            'audio' => 'Audiobook'
        ];
    }
}
