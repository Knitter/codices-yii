<?php

declare(strict_types=1);

namespace Codices\Import;

final class ImportResult {
    /** @param array<int, string> $errors */
    public function __construct(
        public int $imported = 0,
        public int $skipped = 0,
        public array $errors = []
    ) {}
}
