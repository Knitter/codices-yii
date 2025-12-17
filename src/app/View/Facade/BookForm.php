<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\View\Facade;

use Codices\Model\Item;
use yii\base\Model;

final class BookForm extends Model {

    public ?int $id = null;
    public ?int $ownedById = null;
    public string $title = '';
    public ?string $subtitle = null;
    public ?string $originalTitle = null;
    public ?string $plot = null;
    public ?string $isbn = null;
    public ?string $format = null;
    public ?int $pageCount = null;
    public ?string $publishDate = null;
    public ?string $addedOn = null;
    public ?int $publishYear = null;
    public ?string $language = null;
    public ?string $edition = null;
    public ?string $volume = null;
    public ?int $rating = null;
    public ?string $url = null;
    public ?string $review = null;
    public ?int $publisherId = null;
    public ?int $seriesId = null;
    public ?int $collectionId = null;
    public ?int $orderInSeries = null;
    public int $copies = 1;
    public bool $translated = false;
    public bool $read = false;
    public string $type = '';
    public string $cover = '';
    public string $filename = '';
    public string $fileLocation = '';

    public string $narrator = '';
    public string $bitrate = '';
    public string $boughtFrom = '';
    public ?int $duration = null; // in minutes
    public ?int $sizeBytes = null; // in KB
    public ?int $duplicatesId = null;

    /** @var int[] */
    public array $authors = [];
    /** @var int[] */
    public array $genres = [];

    public function init(): void {
        parent::init();
        if ($this->type === '') {
            $this->type = Item::TYPE_PAPER;
        }
    }

    public function rules(): array {
        return [
            [['title'], 'required'],
            [['title', 'subtitle', 'originalTitle', 'language', 'edition', 'volume', 'format', 'fileLocation', 'narrator', 'bitrate', 'boughtFrom'], 'string', 'max' => 255],
            [['plot', 'review'], 'string'],
            [['isbn'], 'string', 'max' => 32],
            [['url'], 'url'],
            [['pageCount', 'publishYear', 'rating', 'publisherId', 'seriesId', 'collectionId', 'orderInSeries', 'copies', 'sizeBytes', 'duplicatesId', 'duration'], 'integer'],
            [['translated', 'read'], 'boolean'],
            [['publishDate'], 'safe'],
            [['type'], 'in', 'range' => [Item::TYPE_PAPER, Item::TYPE_EBOOK, Item::TYPE_AUDIO]],
            [['rating'], 'integer', 'min' => 0, 'max' => 5],
            [['pageCount', 'publishYear', 'orderInSeries', 'copies'], 'integer', 'min' => 0],
            [['authors', 'genres'], 'each', 'rule' => ['integer']],
        ];
    }

    public function attributeLabels(): array {
        return [
            'title' => 'Title',
            'subtitle' => 'Subtitle',
            'originalTitle' => 'Original Title',
            'plot' => 'Plot',
            'isbn' => 'ISBN',
            'format' => 'Format',
            'pageCount' => 'Pages',
            'publishDate' => 'Publish Date',
            'publishYear' => 'Publish Year',
            'language' => 'Language',
            'edition' => 'Edition',
            'volume' => 'Volume',
            'rating' => 'Rating',
            'url' => 'URL',
            'review' => 'Review',
            'publisherId' => 'Publisher',
            'seriesId' => 'Series',
            'collectionId' => 'Collection',
            'orderInSeries' => 'Order in Series',
            'copies' => 'Copies',
            'translated' => 'Translated',
            'read' => 'Read',
            'type' => 'Type',
            'authors' => 'Authors',
            'genres' => 'Genres',
            'cover' => 'Cover',
            'filename' => 'Filename',
            'fileLocation' => 'File Location',
            'narrator' => 'Narrator',
            'bitrate' => 'Bitrate',
            'boughtFrom' => 'Bought From',
            'duration' => 'Duration',
            'sizeBytes' => 'Size',
            'duplicatesId' => 'Duplicates'
        ];
    }

    public function loadFromItem(Item $item): void {
        $this->id = (int)$item->id;
        $this->ownedById = (int)$item->ownedById;
        $this->title = (string)$item->title;
        $this->subtitle = $item->subtitle;
        $this->originalTitle = $item->originalTitle;
        $this->plot = $item->plot;
        $this->isbn = $item->isbn;
        $this->format = $item->format;
        $this->pageCount = $item->pageCount;
        $this->publishDate = $item->publishDate;
        $this->publishYear = $item->publishYear;
        $this->language = $item->language;
        $this->edition = $item->edition;
        $this->volume = $item->volume;
        $this->rating = $item->rating;
        $this->url = $item->url;
        $this->review = $item->review;
        $this->publisherId = $item->publisherId;
        $this->seriesId = $item->seriesId;
        $this->collectionId = $item->collectionId;
        $this->orderInSeries = $item->orderInSeries;
        $this->copies = (int)($item->copies ?? 1);
        $this->translated = (bool)$item->translated;
        $this->read = (bool)$item->read;
        $this->type = (string)$item->type;
        $this->cover = (string)$item->cover;
        $this->filename = (string)$item->filename;
        $this->fileLocation = (string)$item->fileLocation;
        $this->narrator = (string)$item->narrator;
        $this->bitrate = (string)$item->bitrate;
        $this->boughtFrom = (string)$item->boughtFrom;
        $this->duration = (int)$item->duration;
        $this->sizeBytes = (int)$item->sizeBytes;
        $this->duplicatesId = (int)$item->duplicatesId;
    }

    public function applyToItem(Item $item): Item {
        $item->title = $this->title;
        $item->subtitle = $this->subtitle;
        $item->originalTitle = $this->originalTitle;
        $item->plot = $this->plot;
        $item->isbn = $this->isbn;
        $item->format = $this->format;
        $item->pageCount = $this->pageCount;
        $item->publishDate = $this->publishDate;
        $item->publishYear = $this->publishYear;
        $item->language = $this->language;
        $item->edition = $this->edition;
        $item->volume = $this->volume;
        $item->rating = $this->rating;
        $item->url = $this->url;
        $item->review = $this->review;
        $item->publisherId = $this->publisherId;
        $item->seriesId = $this->seriesId;
        $item->collectionId = $this->collectionId;
        $item->orderInSeries = $this->orderInSeries;
        $item->copies = $this->copies;
        $item->translated = $this->translated;
        $item->read = $this->read;
        $item->type = $this->type;
        $item->cover = $this->cover;
        $item->filename = $this->filename;
        $item->fileLocation = $this->fileLocation;
        $item->narrator = $this->narrator;
        $item->bitrate = $this->bitrate;
        $item->boughtFrom = $this->boughtFrom;
        $item->duration = $this->duration;
        $item->sizeBytes = $this->sizeBytes;
        $item->duplicatesId = $this->duplicatesId;

        return $item;
    }
}
