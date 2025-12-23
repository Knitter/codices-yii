<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Repository;

use Codices\Model\Format;
use Codices\Query\FormatFilter;
use Codices\Query\FormatListResult;

interface FormatRepositoryInterface {

    public function findOne(string $type, string $name, int $ownedById): ?Format;

    public function save(Format $format): bool;

    public function delete(Format $format): bool;

    public function search(FormatFilter $filter): FormatListResult;
}
