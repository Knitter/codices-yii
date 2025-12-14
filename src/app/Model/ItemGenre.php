<?php

declare(strict_types=1);

namespace Codices\Model;

use Yiisoft\ActiveRecord\ActiveQueryInterface;
use Yiisoft\ActiveRecord\ActiveRecord;

/**
 * @property int $itemId
 * @property int $genreId
 */
final class ItemGenre extends ActiveRecord {
    public function tableName(): string {
        return 'item_genre';
    }

    public function primaryKey(): array {
        return ['itemId', 'genreId'];
    }

    public function rules(): array {
        return [
            'itemId' => [['required'], ['integer'], ['exist', 'targetClass' => Item::class, 'targetAttribute' => 'id']],
            'genreId' => [['required'], ['integer'], ['exist', 'targetClass' => Genre::class, 'targetAttribute' => 'id']],
        ];
    }

    // Relationships
    public function getItem(): ActiveQueryInterface {
        return $this->hasOne(Item::class, ['id' => 'itemId']);
    }

    public function getGenre(): ActiveQueryInterface {
        return $this->hasOne(Genre::class, ['id' => 'genreId']);
    }
}
