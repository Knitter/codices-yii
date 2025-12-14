<?php

declare(strict_types=1);

namespace Codices\Model;

use Yiisoft\ActiveRecord\ActiveRecord;

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

    public function tableName(): string {
        return 'author';
    }

    public function rules(): array {
        return [
            'name' => [['required'], ['string', 'max' => 255]],
            'ownedById' => [['required'], ['integer'], ['exist', 'targetClass' => Account::class, 'targetAttribute' => 'id']],
            'surname' => [['string', 'max' => 255]],
            'biography' => [['string']],
            'website' => [['string', 'max' => 255], ['url']],
            'photo' => [['string', 'max' => 255]],
        ];
    }

    // Relationships
    public function getOwner() {
        return $this->hasOne(Account::class, ['id' => 'ownedById']);
    }

    public function getItems() {
        return $this->hasMany(Item::class, ['id' => 'itemId'])
            ->viaTable('item_author', ['authorId' => 'id']);
    }

    public function getItemAuthors() {
        return $this->hasMany(ItemAuthor::class, ['authorId' => 'id']);
    }

    public function getFullName(): string {
        return $this->surname ? "{$this->name} {$this->surname}" : $this->name;
    }
}
