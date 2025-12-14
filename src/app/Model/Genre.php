<?php

declare(strict_types=1);

namespace Codices\Model;

use Yiisoft\ActiveRecord\ActiveRecord;

/**
 * @property int $id
 * @property string $name
 * @property int $ownedById
 */
final class Genre extends ActiveRecord {

    public function tableName(): string {
        return 'genre';
    }

    public function rules(): array {
        return [
            'name' => [['required'], ['string', 'max' => 255]],
            'ownedById' => [['required'], ['integer'], ['exist', 'targetClass' => Account::class, 'targetAttribute' => 'id']],
        ];
    }

    // Relationships
    public function getOwner() {
        return $this->hasOne(Account::class, ['id' => 'ownedById']);
    }

    public function getItems() {
        return $this->hasMany(Item::class, ['id' => 'itemId'])
            ->viaTable('item_genre', ['genreId' => 'id']);
    }

    public function getItemGenres() {
        return $this->hasMany(ItemGenre::class, ['genreId' => 'id']);
    }
}
