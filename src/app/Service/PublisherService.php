<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Service;

use Codices\Model\Publisher;
use Codices\Repository\PublisherRepositoryInterface;
use Codices\Query\PublisherFilter;
use Codices\Query\PublisherListResult;
use Codices\View\Facade\PublisherForm;
use RuntimeException;

final readonly class PublisherService {

    public function __construct(private PublisherRepositoryInterface $publishers) {
    }

    public function list(int $page = 1, int $pageSize = 10, string $sort = 'name', string $direction = 'asc'): array {
        return $this->publishers->listPage($page, $pageSize, $sort, $direction);
    }

    public function search(PublisherFilter $filter): PublisherListResult {
        return $this->publishers->search($filter);
    }

    public function findById(int $id): ?Publisher {
        return $this->publishers->findById($id);
    }

    public function create(PublisherForm $form, int $ownerId): Publisher {
        $publisher = new Publisher();
        $publisher->ownedById = $ownerId;
        $form->applyToPublisher($publisher);
        if (!$this->publishers->save($publisher)) {
            throw new RuntimeException('Failed to save publisher');
        }
        return $publisher;
    }

    public function update(int $id, PublisherForm $form): Publisher {
        $publisher = $this->publishers->findById($id);
        if ($publisher === null) {
            throw new RuntimeException('Publisher not found');
        }
        $form->applyToPublisher($publisher);
        if (!$this->publishers->save($publisher)) {
            throw new RuntimeException('Failed to save publisher');
        }
        return $publisher;
    }

    public function delete(int $id): void {
        $publisher = $this->publishers->findById($id);
        if ($publisher === null) {
            return;
        }
        $this->publishers->delete($publisher);
    }
}
