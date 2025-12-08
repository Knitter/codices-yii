<?php

declare(strict_types=1);

namespace App\Model;

use Yiisoft\ActiveRecord\ActiveQueryInterface;
use Yiisoft\ActiveRecord\ActiveRecord;

/**
 * ItemAuthor model - junction table for Item and Author
 *
 * @property int $itemId
 * @property int $authorId
 *
 * @since 2025.1
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
    public function getItem(): ActiveQueryInterface {
        return $this->hasOne(Item::class, ['id' => 'itemId']);
    }

    public function getAuthor(): ActiveQueryInterface {
        return $this->hasOne(Author::class, ['id' => 'authorId']);
    }
}
