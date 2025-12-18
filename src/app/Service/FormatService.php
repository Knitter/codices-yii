<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Service;

use Codices\Model\Format;
use Codices\Repository\FormatRepositoryInterface;
use Codices\Query\FormatFilter;
use Codices\Query\FormatListResult;
use Codices\View\Facade\FormatForm;
use RuntimeException;

final readonly class FormatService {

    public function __construct(private FormatRepositoryInterface $formats) {
    }

    public function list(int $page = 1, int $pageSize = 10, string $sort = 'name', string $direction = 'asc'): array {
        return $this->formats->listPage($page, $pageSize, $sort, $direction);
    }

    public function search(FormatFilter $filter): FormatListResult {
        return $this->formats->search($filter);
    }

    public function findOne(string $type, string $name, int $ownerId): ?Format {
        return $this->formats->findOne($type, $name, $ownerId);
    }

    public function create(FormatForm $form, int $ownerId): Format {
        $format = new Format();
        $format->ownedById = $ownerId;
        $form->applyToFormat($format);
        if (!$this->formats->save($format)) {
            throw new RuntimeException('Failed to save format');
        }
        return $format;
    }

    public function update(string $type, string $name, int $ownerId, FormatForm $form): Format {
        $format = $this->formats->findOne($type, $name, $ownerId);
        if ($format === null) {
            throw new RuntimeException('Format not found');
        }
        $form->applyToFormat($format);
        if (!$this->formats->save($format)) {
            throw new RuntimeException('Failed to save format');
        }
        return $format;
    }

    public function delete(string $type, string $name, int $ownerId): void {
        $format = $this->formats->findOne($type, $name, $ownerId);
        if ($format === null) {
            return;
        }
        $this->formats->delete($format);
    }
}
