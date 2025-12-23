<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Service;

use Codices\Model\Item;
use Codices\Query\ItemFilter;
use Codices\Query\ItemSearchResult;
use Codices\Query\PublisherFilter;
use Codices\Query\PublisherListResult;
use Codices\Repository\ItemRepositoryInterface;
use Codices\View\Facade\BookForm;
use RuntimeException;
use Throwable;
use yii\db\Connection;
use yii\db\Exception;
use yii\db\StaleObjectException;

final readonly class ItemService {

    public function __construct(
        private ItemRepositoryInterface $items,
        private Connection              $db
    ) {
    }

    public function list(int $page = 1, int $pageSize = 10, string $sort = 'title', string $direction = 'asc'): array {
        return $this->items->list($page, $pageSize, $sort, $direction);
    }

    public function search(ItemFilter $filter): ItemSearchResult {
        return $this->items->search($filter);
    }

    /**
     * @throws Throwable
     * @throws Exception
     */
    public function create(BookForm $form, int $ownerId): Item {
        $transaction = $this->db->beginTransaction();
        try {
            $item = new Item();
            $item->ownedById = $ownerId;
            $form->applyToItem($item);

            if (!$this->items->save($item)) {
                throw new RuntimeException('Failed to save item');
            }

            $this->items->replaceAuthors((int)$item->id, $form->authors ?? []);
            $this->items->replaceGenres((int)$item->id, $form->genres ?? []);
            $transaction->commit();
        } catch (Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

        return $item;
    }

    /**
     * @throws Throwable
     * @throws Exception
     */
    public function update(int $id, BookForm $form, int $ownerId): Item {
        $item = $this->items->findById($id);
        if ($item === null) {
            throw new RuntimeException('Item not found');
        }

        $transaction = $this->db->beginTransaction();
        try {
            $item->ownedById = $ownerId;
            $form->applyToItem($item);

            if (!$this->items->save($item)) {
                throw new RuntimeException('Failed to save item');
            }

            $this->items->replaceAuthors((int)$item->id, $form->authors ?? []);
            $this->items->replaceGenres((int)$item->id, $form->genres ?? []);
            $transaction->commit();
        } catch (Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

        return $item;
    }

    /**
     * @throws StaleObjectException|Throwable
     */
    public function delete(int $id): void {
        $item = $this->items->findById($id);
        if ($item === null) {
            return;
        }

        $transaction = $this->db->beginTransaction();
        try {
            $this->items->replaceAuthors((int)$item->id, []);
            $this->items->replaceGenres((int)$item->id, []);
            if ($item->delete() === false) {
                throw new RuntimeException('Failed to delete item');
            }

            $transaction->commit();
        } catch (Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}
