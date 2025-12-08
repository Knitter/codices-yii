<?php

declare(strict_types=1);

namespace App\app\Model;

use Yiisoft\ActiveRecord\ActiveRecord;

/**
 * Format model
 *
 * @property string $type
 * @property string $name
 * @property int $ownedById
 *
 * @since 2025.1
 */
final class Format extends ActiveRecord {

    public function tableName(): string {
        return 'format';
    }

    public function primaryKey(): array {
        return ['type', 'name', 'ownedById'];
    }

    public function rules(): array {
        return [
            'type' => [['required'], ['string', 'max' => 255]],
            'name' => [['required'], ['string', 'max' => 255]],
            'ownedById' => [['required'], ['integer'], ['exist', 'targetClass' => Account::class, 'targetAttribute' => 'id']],
        ];
    }

    // Relationships
    public function getOwner() {
        return $this->hasOne(Account::class, ['id' => 'ownedById']);
    }

    public function getItems() {
        return $this->hasMany(Item::class, ['format' => 'name'])
            ->andWhere(['type' => $this->type]);
    }

    public static function getFormatTypes(): array {
        return [
            'paper' => 'Paper Book',
            'ebook' => 'E-Book',
            'audio' => 'Audiobook'
        ];
    }
}
