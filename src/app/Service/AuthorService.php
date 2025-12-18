<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Service;

use Codices\Model\Author;
use Codices\Repository\AuthorRepositoryInterface;
use Codices\Query\AuthorFilter;
use Codices\Query\AuthorListResult;
use Codices\View\Facade\AuthorForm;
use RuntimeException;

final readonly class AuthorService {

    public function __construct(private AuthorRepositoryInterface $authors) {
    }

    public function list(int $page = 1, int $pageSize = 10, string $sort = 'name', string $direction = 'asc'): array {
        return $this->authors->listPage($page, $pageSize, $sort, $direction);
    }

    public function search(AuthorFilter $filter): AuthorListResult {
        return $this->authors->search($filter);
    }

    public function findById(int $id): ?Author {
        return $this->authors->findById($id);
    }

    public function create(AuthorForm $form, int $ownerId): Author {
        $author = new Author();
        $author->ownedById = $ownerId;
        $form->applyToAuthor($author);
        if (!$this->authors->save($author)) {
            throw new RuntimeException('Failed to save author');
        }
        return $author;
    }

    public function update(int $id, AuthorForm $form): Author {
        $author = $this->authors->findById($id);
        if ($author === null) {
            throw new RuntimeException('Author not found');
        }
        $form->applyToAuthor($author);
        if (!$this->authors->save($author)) {
            throw new RuntimeException('Failed to save author');
        }
        return $author;
    }

    public function delete(int $id): void {
        $author = $this->authors->findById($id);
        if ($author === null) {
            return;
        }
        $this->authors->delete($author);
    }
}
