<?php

declare(strict_types=1);

namespace Codices\Import;

final class ImportPreviewRow {

    public function __construct(
        public int     $index,
        public string  $title,
        public array   $authors, // list of author display names
        public array   $genres,  // list of genre names
        public ?string $series,
        public ?int    $orderInSeries,
        public ?string $publisher,
        public ?int    $year,
        public ?string $language,
        public ?string $isbn,
        public string  $itemType, // paper|ebook|audio
        public ?string $formatName,
        public array   $errors = [],
        public bool    $duplicateIsbn = false,
        public bool    $existsInDb = false,
    ) {
    }

    /** @return array<string, mixed> */
    public function toArray(): array {
        return [
            'index' => $this->index,
            'title' => $this->title,
            'authors' => $this->authors,
            'genres' => $this->genres,
            'series' => $this->series,
            'orderInSeries' => $this->orderInSeries,
            'publisher' => $this->publisher,
            'year' => $this->year,
            'language' => $this->language,
            'isbn' => $this->isbn,
            'itemType' => $this->itemType,
            'formatName' => $this->formatName,
            'errors' => $this->errors,
            'duplicateIsbn' => $this->duplicateIsbn,
            'existsInDb' => $this->existsInDb,
        ];
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self {
        return new self(
            (int)$data['index'],
            (string)$data['title'],
            (array)($data['authors'] ?? []),
            (array)($data['genres'] ?? []),
            $data['series'] ?? null,
            isset($data['orderInSeries']) ? (int)$data['orderInSeries'] : null,
            $data['publisher'] ?? null,
            isset($data['year']) ? (int)$data['year'] : null,
            $data['language'] ?? null,
            $data['isbn'] ?? null,
            (string)($data['itemType'] ?? 'paper'),
            $data['formatName'] ?? null,
            (array)($data['errors'] ?? []),
            (bool)($data['duplicateIsbn'] ?? false),
            (bool)($data['existsInDb'] ?? false),
        );
    }
}
