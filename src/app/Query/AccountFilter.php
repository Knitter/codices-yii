<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Query;

final readonly class AccountFilter {

    public function __construct(
        public ?string $username = null,
        public ?string $email = null,
        public ?string $name = null,
        public ?int    $active = null, // 1, 0 or null (all)
        public string  $sort = 'username',
        public string  $direction = 'asc',
        public int     $page = 1,
        public int     $pageSize = 25,
    ) {
    }

    /**
     * @param array<string, mixed> $query
     */
    public static function fromArray(array $query): self {
        $username = self::nullIfEmpty($query['username'] ?? null);
        $email = self::nullIfEmpty($query['email'] ?? null);
        $name = self::nullIfEmpty($query['name'] ?? null);

        $activeParam = $query['active'] ?? null;
        $active = null;
        if ($activeParam !== null && $activeParam !== '') {
            $active = (int)$activeParam;
            if ($active !== 0 && $active !== 1) {
                $active = null;
            }
        }

        $allowedSort = ['id', 'username', 'email', 'name'];
        $sort = in_array(($query['sort'] ?? 'username'), $allowedSort, true)
            ? (string)$query['sort']
            : 'username';

        $direction = strtolower((string)($query['sort_dir'] ?? ($query['direction'] ?? 'asc')));
        $direction = $direction === 'desc' ? 'desc' : 'asc';

        $page = max(1, (int)($query['page'] ?? 1));
        $pageSize = max(1, min(100, (int)($query['per_page'] ?? ($query['pageSize'] ?? 25))));

        return new self($username, $email, $name, $active, $sort, $direction, $page, $pageSize);
    }

    private static function nullIfEmpty(?string $value): ?string {
        $v = $value !== null ? trim($value) : null;
        return $v === '' ? null : $v;
    }
}
