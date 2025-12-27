<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Model;

use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $title
 * @property int $ownedById
 * @property string $type
 * @property bool $translated
 * @property bool $read
 * @property int $copies
 * @property string|null $subtitle
 * @property string|null $originalTitle
 * @property string|null $plot
 * @property string|null $isbn
 * @property string|null $format
 * @property int|null $pageCount
 * @property string|null $publishDate
 * @property int|null $publishYear
 * @property string|null $addedOn
 * @property string|null $language
 * @property string|null $edition
 * @property string|null $volume
 * @property int|null $rating
 * @property string|null $url
 * @property string|null $review
 * @property string|null $cover
 * @property string|null $filename
 * @property string|null $fileLocation
 * @property string|null $narrator For audiobooks, the narrator's name
 * @property string|null $bitrate
 * @property string|null $boughtFrom
 * @property int|null $duration For audiobooks, in minutes
 * @property int|null $sizeBytes
 * @property int|null $orderInSeries
 * @property int|null $publisherId
 * @property int|null $seriesId
 * @property int|null $collectionId
 * @property int|null $duplicatesId
 */
final class Item extends ActiveRecord {

    public final const string TYPE_PAPER = 'paper';
    public final const string TYPE_EBOOK = 'ebook';
    public final const string TYPE_AUDIO = 'audio';

    public static function tableName(): string {
        return 'item';
    }

    public function beforeSave($insert): bool {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($insert && empty($this->addedOn)) {
            $this->addedOn = date('Y-m-d');
        }

        return true;
    }

    // Relationships
    public function getOwner(): ActiveQuery {
        return $this->hasOne(Account::class, ['id' => 'ownedById']);
    }

    public function getPublisher(): ActiveQuery {
        return $this->hasOne(Publisher::class, ['id' => 'publisherId']);
    }

    public function getSeries(): ActiveQuery {
        return $this->hasOne(Series::class, ['id' => 'seriesId']);
    }

    public function getCollection(): ActiveQuery {
        return $this->hasOne(Collection::class, ['id' => 'collectionId']);
    }

    public function getDuplicate(): ActiveQuery {
        return $this->hasOne(Item::class, ['id' => 'duplicatesId']);
    }

    public function getDuplicates(): ActiveQuery {
        return $this->hasMany(Item::class, ['duplicatesId' => 'id']);
    }

    /**
     * @throws InvalidConfigException
     */
    public function getAuthors(): ActiveQuery {
        return $this->hasMany(Author::class, ['id' => 'authorId'])
            ->viaTable('item_author', ['itemId' => 'id']);
    }

    /**
     * @throws InvalidConfigException
     */
    public function getGenres(): ActiveQuery {
        return $this->hasMany(Genre::class, ['id' => 'genreId'])
            ->viaTable('item_genre', ['itemId' => 'id']);
    }

    public function getItemAuthors(): ActiveQuery {
        return $this->hasMany(ItemAuthor::class, ['itemId' => 'id']);
    }

    public function getItemGenres(): ActiveQuery {
        return $this->hasMany(ItemGenre::class, ['itemId' => 'id']);
    }

    public function isPaper(): bool {
        return $this->type === self::TYPE_PAPER;
    }

    public function isEbook(): bool {
        return $this->type === self::TYPE_EBOOK;
    }

    public function isAudio(): bool {
        return $this->type === self::TYPE_AUDIO;
    }
}
