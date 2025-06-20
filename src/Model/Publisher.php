<?php

declare(strict_types=1);

namespace App\Model;

use Yiisoft\ActiveRecord\ActiveRecord;

/**
 * Publisher model
 *
 * @property int $id
 * @property string $name
 * @property int $ownedById
 * @property string|null $summary
 * @property string|null $website
 */
final class Publisher extends ActiveRecord {
    public function tableName(): string {
        return 'publisher';
    }

    public function rules(): array {
        return [
            'name' => [['required'], ['string', 'max' => 255]],
            'ownedById' => [['required'], ['integer'], ['exist', 'targetClass' => Account::class, 'targetAttribute' => 'id']],
            'summary' => [['string']],
            'website' => [['string', 'max' => 255], ['url']],
        ];
    }

    // Relationships
    public function getOwner() {
        return $this->hasOne(Account::class, ['id' => 'ownedById']);
    }

    public function getItems() {
        return $this->hasMany(Item::class, ['publisherId' => 'id']);
    }
}
