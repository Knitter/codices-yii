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
 * @property string|null $summary
 * @property string|null $website
 */
final class Publisher extends ActiveRecord {

    public static function tableName(): string {
        return 'publisher';
    }

    // Relationships
    public function getOwner(): ActiveQuery {
        return $this->hasOne(Account::class, ['id' => 'ownedById']);
    }

    public function getItems(): ActiveQuery {
        return $this->hasMany(Item::class, ['publisherId' => 'id']);
    }
}
