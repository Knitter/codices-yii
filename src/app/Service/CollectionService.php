<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Service;

use Codices\Model\Collection;
use Codices\Repository\CollectionRepositoryInterface;
use Codices\View\Facade\CollectionForm;
use RuntimeException;

final readonly class CollectionService {

    public function __construct(private CollectionRepositoryInterface $collections) {
    }

    public function list(int $page = 1, int $pageSize = 10, string $sort = 'name', string $direction = 'asc'): array {
        return $this->collections->listPage($page, $pageSize, $sort, $direction);
    }

    public function findById(int $id): ?Collection {
        return $this->collections->findById($id);
    }

    public function create(CollectionForm $form, int $ownerId): Collection {
        $collection = new Collection();
        $collection->ownedById = $ownerId;
        $form->applyToCollection($collection);
        if (!$this->collections->save($collection)) {
            throw new RuntimeException('Failed to save collection');
        }
        return $collection;
    }

    public function update(int $id, CollectionForm $form): Collection {
        $collection = $this->collections->findById($id);
        if ($collection === null) {
            throw new RuntimeException('Collection not found');
        }
        $form->applyToCollection($collection);
        if (!$this->collections->save($collection)) {
            throw new RuntimeException('Failed to save collection');
        }
        return $collection;
    }

    public function delete(int $id): void {
        $collection = $this->collections->findById($id);
        if ($collection === null) {
            return;
        }
        $this->collections->delete($collection);
    }
}
