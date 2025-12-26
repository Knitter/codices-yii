<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Query;

final readonly class ItemFilter {

    public function __construct(
        public ?string $title = null,
        public ?string $authorName = null,
        public ?int    $genreId = null,
        public ?int    $publisherId = null,
        public ?int    $yearFrom = null,
        public ?int    $yearTo = null,
        public ?int    $rating = null,
        public ?string $type = null,
        public string  $sort = 'title',
        public string  $direction = 'asc', //TODO: Replace with SORT_ASC|SORT_DESC PHP constants
        public int     $page = 1,
        public int     $pageSize = 25,
    ) {
    }

    /**
     * Build a filter from query params (strings) safely. Unknown keys are ignored.
     *
     * @param array<string, mixed> $query
     * @return ItemFilter
     */
    public static function fromArray(array $query): self {
        $title = self::nullIfEmpty($query['title'] ?? null);
        $authorName = self::nullIfEmpty($query['author'] ?? ($query['authorName'] ?? null));
        $genreId = self::toIntOrNull($query['genre_id'] ?? ($query['genreId'] ?? null));
        $publisherId = self::toIntOrNull($query['publisher_id'] ?? ($query['publisherId'] ?? null));
        $yearFrom = self::toIntOrNull($query['year_from'] ?? ($query['yearFrom'] ?? null));
        $yearTo = self::toIntOrNull($query['year_to'] ?? ($query['yearTo'] ?? null));
        $rating = self::toIntOrNull($query['rating'] ?? null);
        $type = self::nullIfEmpty($query['type'] ?? null);
        // allow only known types
        $allowedTypes = ['paper', 'ebook', 'audio'];
        if ($type !== null && !in_array($type, $allowedTypes, true)) {
            $type = null;
        }

        $sort = (string)($query['sort'] ?? 'title');
        $sort = in_array($sort, ['title', 'publishYear', 'rating', 'addedOn'], true) ? $sort : 'title';

        $direction = strtolower((string)($query['sort_dir'] ?? ($query['direction'] ?? 'asc')));
        $direction = $direction === 'desc' ? 'desc' : 'asc';
        $page = max(1, (int)($query['page'] ?? 1));
        $pageSize = max(1, min(100, (int)($query['per_page'] ?? ($query['pageSize'] ?? 20))));

        return new self(
            $title, $authorName, $genreId, $publisherId, $yearFrom, $yearTo, $rating, $type, $sort, $direction,
            $page, $pageSize
        );
    }

    //TODO: Extract into reusable class/helper or trait
    private static function nullIfEmpty(?string $value): ?string {
        $value = $value !== null ? trim($value) : null;
        return $value === '' ? null : $value;
    }

    //TODO: Extract into reusable class/helper or trait
    private static function toIntOrNull($value): ?int {
        if ($value === null || $value === '') {
            return null;
        }
        $i = (int)$value;
        return $i > 0 ? $i : null;
    }
}
