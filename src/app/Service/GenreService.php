<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Service;

use Codices\Model\Genre;
use Codices\Repository\GenreRepositoryInterface;
use Codices\Query\GenreFilter;
use Codices\Query\GenreListResult;
use Codices\View\Facade\GenreForm;
use RuntimeException;

final readonly class GenreService {

    public function __construct(private GenreRepositoryInterface $genres) {
    }

    public function list(int $page = 1, int $pageSize = 10, string $sort = 'name', string $direction = 'asc'): array {
        return $this->genres->list($page, $pageSize, $sort, $direction);
    }

    public function search(GenreFilter $filter): GenreListResult {
        return $this->genres->search($filter);
    }

    public function findById(int $id): ?Genre {
        return $this->genres->findById($id);
    }

    public function create(GenreForm $form, int $ownerId): Genre {
        $genre = new Genre();
        $genre->ownedById = $ownerId;
        $form->applyToGenre($genre);
        if (!$this->genres->save($genre)) {
            throw new RuntimeException('Failed to save genre');
        }
        return $genre;
    }

    public function update(int $id, GenreForm $form): Genre {
        $genre = $this->genres->findById($id);
        if ($genre === null) {
            throw new RuntimeException('Genre not found');
        }
        $form->applyToGenre($genre);
        if (!$this->genres->save($genre)) {
            throw new RuntimeException('Failed to save genre');
        }
        return $genre;
    }

    public function delete(int $id): void {
        $genre = $this->genres->findById($id);
        if ($genre === null) {
            return;
        }
        $this->genres->delete($genre);
    }
}
