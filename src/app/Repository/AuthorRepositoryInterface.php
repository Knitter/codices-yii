<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Repository;

use Codices\Model\Author;
use Codices\Query\AuthorFilter;
use Codices\Query\AuthorListResult;

interface AuthorRepositoryInterface {

    public function findById(int $id): ?Author;

    public function save(Author $author): bool;

    public function delete(Author $author): bool;

    public function search(AuthorFilter $filter): AuthorListResult;
}
