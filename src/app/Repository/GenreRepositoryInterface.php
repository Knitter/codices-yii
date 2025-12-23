<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Repository;

use Codices\Model\Genre;
use Codices\Query\GenreFilter;
use Codices\Query\GenreListResult;

interface GenreRepositoryInterface {

    public function findById(int $id): ?Genre;

    public function save(Genre $genre): bool;

    public function delete(Genre $genre): bool;

    public function search(GenreFilter $filter): GenreListResult;
}
