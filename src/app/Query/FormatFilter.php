<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Query;

final readonly class FormatFilter {

    public function __construct(
        public ?string $name = null,
        public string  $sort = 'name',
        public string  $direction = 'asc',
        public int     $page = 1,
        public int     $pageSize = 25,
    ) {
    }

    /**
     * @param array<string, mixed> $query
     */
    public static function fromArray(array $query): self {
        $name = self::nullIfEmpty($query['name'] ?? null);

        $sort = in_array(($query['sort'] ?? 'name'), ['name', 'type'], true)
            ? (string)$query['sort']
            : 'name';

        $direction = strtolower((string)($query['sort_dir'] ?? ($query['direction'] ?? 'asc')));
        $direction = $direction === 'desc' ? 'desc' : 'asc';

        $page = max(1, (int)($query['page'] ?? 1));
        $pageSize = max(1, min(100, (int)($query['per_page'] ?? ($query['pageSize'] ?? 20))));

        return new self($name, $sort, $direction, $page, $pageSize);
    }

    private static function nullIfEmpty(?string $value): ?string {
        $value = $value !== null ? trim($value) : null;
        return $value === '' ? null : $value;
    }
}
