<?php

declare(strict_types=1);

namespace Codices\Query;

final class ItemFilter
{
    public function __construct(
        public readonly ?string $title = null,
        public readonly ?string $authorName = null,
        public readonly ?int $genreId = null,
        public readonly ?int $publisherId = null,
        public readonly ?int $yearFrom = null,
        public readonly ?int $yearTo = null,
        public readonly ?int $rating = null,
        public readonly string $sort = 'title',
        public readonly string $direction = 'asc',
        public readonly int $page = 1,
        public readonly int $pageSize = 20,
    ) {
    }

    /**
     * Build a filter from query params (strings) safely.
     * Unknown keys are ignored.
     */
    public static function fromArray(array $query): self
    {
        $title = self::nullIfEmpty($query['title'] ?? null);
        $authorName = self::nullIfEmpty($query['author'] ?? ($query['authorName'] ?? null));
        $genreId = self::toIntOrNull($query['genre_id'] ?? ($query['genreId'] ?? null));
        $publisherId = self::toIntOrNull($query['publisher_id'] ?? ($query['publisherId'] ?? null));
        $yearFrom = self::toIntOrNull($query['year_from'] ?? ($query['yearFrom'] ?? null));
        $yearTo = self::toIntOrNull($query['year_to'] ?? ($query['yearTo'] ?? null));
        $rating = self::toIntOrNull($query['rating'] ?? null);
        $sort = in_array(($query['sort'] ?? 'title'), ['title', 'publishYear', 'rating', 'addedOn'], true)
            ? $query['sort']
            : 'title';
        $direction = strtolower((string)($query['sort_dir'] ?? ($query['direction'] ?? 'asc')));
        $direction = $direction === 'desc' ? 'desc' : 'asc';
        $page = max(1, (int)($query['page'] ?? 1));
        $pageSize = max(1, min(100, (int)($query['per_page'] ?? ($query['pageSize'] ?? 20))));

        return new self(
            $title,
            $authorName,
            $genreId,
            $publisherId,
            $yearFrom,
            $yearTo,
            $rating,
            $sort,
            $direction,
            $page,
            $pageSize,
        );
    }

    private static function nullIfEmpty(?string $value): ?string
    {
        $value = $value !== null ? trim($value) : null;
        return $value === '' ? null : $value;
    }

    private static function toIntOrNull($value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }
        $i = (int)$value;
        return $i > 0 ? $i : null;
    }
}
