<?php

declare(strict_types=1);

namespace App\Model;

use Yiisoft\ActiveRecord\ActiveRecord;

/**
 * Collection model
 *
 * @property int $id
 * @property string $name
 * @property int $ownedById
 * @property string|null $publishDate
 * @property int|null $publishYear
 * @property string|null $description
 *
 * @since 2025.1
 */
final class Collection extends ActiveRecord {

    public function tableName(): string {
        return 'collection';
    }

    public function rules(): array {
        return [
            'name' => [['required'], ['string', 'max' => 255]],
            'ownedById' => [['required'], ['integer'], ['exist', 'targetClass' => Account::class, 'targetAttribute' => 'id']],
            'publishDate' => [['string', 'max' => 255]],
            'publishYear' => [['integer']],
            'description' => [['string']],
        ];
    }

    // Relationships
    public function getOwner() {
        return $this->hasOne(Account::class, ['id' => 'ownedById']);
    }

    public function getItems() {
        return $this->hasMany(Item::class, ['collectionId' => 'id']);
    }
}
