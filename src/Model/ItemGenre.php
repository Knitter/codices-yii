<?php

declare(strict_types=1);

namespace App\Model;

use Yiisoft\ActiveRecord\ActiveRecord;

/**
 * ItemGenre model - junction table for Item and Genre
 *
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
    public function getItem() {
        return $this->hasOne(Item::class, ['id' => 'itemId']);
    }

    public function getGenre() {
        return $this->hasOne(Genre::class, ['id' => 'genreId']);
    }
}
