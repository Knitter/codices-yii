<?php

declare(strict_types=1);

namespace App\Model;

use Yiisoft\ActiveRecord\ActiveRecord;

/**
 * ItemAuthor model - junction table for Item and Author
 *
 * @property int $itemId
 * @property int $authorId
 */
final class ItemAuthor extends ActiveRecord {
    public function tableName(): string {
        return 'item_author';
    }

    public function primaryKey(): array {
        return ['itemId', 'authorId'];
    }

    public function rules(): array {
        return [
            'itemId' => [['required'], ['integer'], ['exist', 'targetClass' => Item::class, 'targetAttribute' => 'id']],
            'authorId' => [['required'], ['integer'], ['exist', 'targetClass' => Author::class, 'targetAttribute' => 'id']],
        ];
    }

    // Relationships
    public function getItem() {
        return $this->hasOne(Item::class, ['id' => 'itemId']);
    }

    public function getAuthor() {
        return $this->hasOne(Author::class, ['id' => 'authorId']);
    }
}
