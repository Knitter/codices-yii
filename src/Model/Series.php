<?php

declare(strict_types=1);

namespace App\Model;

use Yiisoft\ActiveRecord\ActiveQueryInterface;
use Yiisoft\ActiveRecord\ActiveRecord;

/**
 * @property int $id
 * @property string $name
 * @property int $ownedById
 * @property bool $completed
 * @property int|null $bookCount
 * @property int|null $ownedCount
 *
 * @since 2025.1
 */
final class Series extends ActiveRecord {

    public function tableName(): string {
        return 'series';
    }

    public function rules(): array {
        return [
            'name' => [['required'], ['string', 'max' => 255]],
            'ownedById' => [['required'], ['integer'], ['exist', 'targetClass' => Account::class, 'targetAttribute' => 'id']],
            'completed' => [['boolean']],
            'bookCount' => [['integer']],
            'ownedCount' => [['integer']],
        ];
    }

    // Relationships
    public function getOwner(): ActiveQueryInterface {
        return $this->hasOne(Account::class, ['id' => 'ownedById']);
    }

    public function getItems(): ActiveQueryInterface {
        return $this->hasMany(Item::class, ['seriesId' => 'id']);
    }
}
