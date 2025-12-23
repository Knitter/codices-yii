<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Service;

use Codices\Model\Series;
use Codices\Repository\SeriesRepositoryInterface;
use Codices\Query\SeriesFilter;
use Codices\Query\SeriesListResult;
use Codices\View\Facade\SeriesForm;
use RuntimeException;

final readonly class SeriesService {

    public function __construct(private SeriesRepositoryInterface $seriesRepo) {
    }

    public function list(int $page = 1, int $pageSize = 10, string $sort = 'name', string $direction = 'asc'): array {
        return $this->seriesRepo->list($page, $pageSize, $sort, $direction);
    }

    public function search(SeriesFilter $filter): SeriesListResult {
        return $this->seriesRepo->search($filter);
    }

    public function findById(int $id): ?Series {
        return $this->seriesRepo->findById($id);
    }

    public function create(SeriesForm $form, int $ownerId): Series {
        $series = new Series();
        $series->ownedById = $ownerId;
        $form->applyToSeries($series);
        if (!$this->seriesRepo->save($series)) {
            throw new RuntimeException('Failed to save series');
        }
        return $series;
    }

    public function update(int $id, SeriesForm $form): Series {
        $series = $this->seriesRepo->findById($id);
        if ($series === null) {
            throw new RuntimeException('Series not found');
        }
        $form->applyToSeries($series);
        if (!$this->seriesRepo->save($series)) {
            throw new RuntimeException('Failed to save series');
        }
        return $series;
    }

    public function delete(int $id): void {
        $series = $this->seriesRepo->findById($id);
        if ($series === null) {
            return;
        }
        $this->seriesRepo->delete($series);
    }
}
