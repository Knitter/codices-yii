<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Query;

use Codices\Model\Account;

final readonly class AccountListResult {

    /** @param Account[] $items */
    public function __construct(
        public array $items,
        public int   $total,
        public int   $page,
        public int   $pageSize,
    ) {
    }

    public function isEmpty(): bool {
        return empty($this->items);
    }
}
