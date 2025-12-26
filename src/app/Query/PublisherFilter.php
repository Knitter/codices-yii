<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Query;

final readonly class PublisherFilter {

    public function __construct(
        public ?int    $id = null,
        public ?string $name = null,
        public string  $sort = 'name',
        public string  $direction = 'asc', // asc|desc
        public int     $page = 1,
        public int     $pageSize = 20,
    ) {
    }

    /**
     * Build a filter from query params (strings) safely. Unknown keys are ignored.
     *
     * @param array<string, mixed> $query
     */
    public static function fromArray(array $query): self {
        $id = (isset($query['id']) && $query['id'] !== '') ? (int)$query['id'] : null;
        $name = self::nullIfEmpty($query['name'] ?? ($query['q'] ?? null));

        $sort = (string)($query['sort'] ?? 'name');
        $sort = in_array($sort, ['name', 'id'], true) ? $sort : 'name';

        $direction = strtolower((string)($query['sort_dir'] ?? ($query['direction'] ?? 'asc')));
        $direction = $direction === 'desc' ? 'desc' : 'asc';

        $page = max(1, (int)($query['page'] ?? 1));
        $pageSize = max(1, min(100, (int)($query['per_page'] ?? ($query['pageSize'] ?? 20))));

        return new self($id, $name, $sort, $direction, $page, $pageSize);
    }

    //TODO: Extract helpers to a shared utility if needed
    private static function nullIfEmpty(?string $value): ?string {
        $value = $value !== null ? trim($value) : null;
        return $value === '' ? null : $value;
    }
}
