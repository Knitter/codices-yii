<?php

declare(strict_types=1);

namespace App\Model;

use Yiisoft\ActiveRecord\ActiveRecord;

/**
 * Item model - represents a book, ebook, or audiobook
 *
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
 *
 * @since 2025.1
 */
final class Item extends ActiveRecord {

    public final const string TYPE_PAPER = 'paper';
    public final const string TYPE_EBOOK = 'ebook';
    public final const string TYPE_AUDIO = 'audio';

    public function tableName(): string {
        return 'item';
    }

    public function rules(): array {
        return [
            'title' => [['required'], ['string', 'max' => 255]],
            'ownedById' => [['required'], ['integer'], ['exist', 'targetClass' => Account::class, 'targetAttribute' => 'id']],
            'type' => [['required'], ['string', 'max' => 255], ['in', 'range' => [self::TYPE_PAPER, self::TYPE_EBOOK, self::TYPE_AUDIO]]],
            'translated' => [['boolean']],
            'read' => [['boolean']],
            'copies' => [['integer']],
            'subtitle' => [['string', 'max' => 255]],
            'originalTitle' => [['string', 'max' => 255]],
            'plot' => [['string']],
            'isbn' => [['string', 'max' => 255]],
            'format' => [['string', 'max' => 255]],
            'pageCount' => [['integer']],
            'publishDate' => [['string', 'max' => 255]],
            'publishYear' => [['integer']],
            'addedOn' => [['string', 'max' => 255]],
            'language' => [['string', 'max' => 255]],
            'edition' => [['string', 'max' => 255]],
            'volume' => [['string', 'max' => 255]],
            'rating' => [['integer', 'min' => 0, 'max' => 5]],
            'url' => [['string', 'max' => 255], ['url']],
            'review' => [['string']],
            'cover' => [['string', 'max' => 255]],
            'filename' => [['string', 'max' => 255]],
            'fileLocation' => [['string', 'max' => 255]],
            'narrator' => [['string', 'max' => 255]],
            'bitrate' => [['string', 'max' => 255]],
            'boughtFrom' => [['string', 'max' => 255]],
            'duration' => [['integer']],
            'sizeBytes' => [['integer']],
            'orderInSeries' => [['integer']],
            'publisherId' => [['integer'], ['exist', 'targetClass' => Publisher::class, 'targetAttribute' => 'id']],
            'seriesId' => [['integer'], ['exist', 'targetClass' => Series::class, 'targetAttribute' => 'id']],
            'collectionId' => [['integer'], ['exist', 'targetClass' => Collection::class, 'targetAttribute' => 'id']],
            'duplicatesId' => [['integer'], ['exist', 'targetClass' => Item::class, 'targetAttribute' => 'id']],
        ];
    }

    public function beforeSave(bool $insert): bool {
        if (parent::beforeSave($insert)) {
            if ($insert && empty($this->addedOn)) {
                $this->addedOn = date('Y-m-d');
            }

            return true;
        }

        return false;
    }

    // Relationships
    public function getOwner() {
        return $this->hasOne(Account::class, ['id' => 'ownedById']);
    }

    public function getPublisher() {
        return $this->hasOne(Publisher::class, ['id' => 'publisherId']);
    }

    public function getSeries() {
        return $this->hasOne(Series::class, ['id' => 'seriesId']);
    }

    public function getCollection() {
        return $this->hasOne(Collection::class, ['id' => 'collectionId']);
    }

    public function getDuplicate() {
        return $this->hasOne(Item::class, ['id' => 'duplicatesId']);
    }

    public function getDuplicates() {
        return $this->hasMany(Item::class, ['duplicatesId' => 'id']);
    }

    public function getAuthors() {
        return $this->hasMany(Author::class, ['id' => 'authorId'])
            ->viaTable('item_author', ['itemId' => 'id']);
    }

    public function getGenres() {
        return $this->hasMany(Genre::class, ['id' => 'genreId'])
            ->viaTable('item_genre', ['itemId' => 'id']);
    }

    public function getItemAuthors() {
        return $this->hasMany(ItemAuthor::class, ['itemId' => 'id']);
    }

    public function getItemGenres() {
        return $this->hasMany(ItemGenre::class, ['itemId' => 'id']);
    }

    public static function getTypes(): array {
        return [
            self::TYPE_PAPER => 'Paper Book',
            self::TYPE_EBOOK => 'E-Book',
            self::TYPE_AUDIO => 'Audiobook'
        ];
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
