<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Repository;

use Codices\Model\Item;
use Codices\Query\ItemFilter;
use Codices\Query\ItemSearchResult;
use Yii;
use yii\db\Exception;
use yii\db\Expression;
use yii\db\StaleObjectException;

final class ItemRepository implements ItemRepositoryInterface {

    public function findById(int $id): ?Item {
        return Item::findOne($id);
    }

    /**
     * @throws Exception
     */
    public function save(Item $item): bool {
        return (bool)$item->save();
    }

    /**
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function delete(Item $item): bool {
        return (bool)$item->delete();
    }

    public function search(ItemFilter $filter): ItemSearchResult {
        $needAuthorJoin = $filter->authorName !== null;
        $needGenreJoin = $filter->genreId !== null;

        $offset = ($filter->page - 1) * $filter->pageSize;
        $sort = [
            'title' => 'i.title',
            'publishYear' => 'i.publishYear',
            'rating' => 'i.rating',
            'addedOn' => 'i.addedOn',
        ];

        $sortBy = $sort[$filter->sort] ?? 'i.title';
        $sortDirection = $filter->direction === 'desc' ? SORT_DESC : SORT_ASC;

        $q = Item::find()
            ->alias('i')
            ->andFilterWhere(['like', 'i.title', $filter->title])
            ->andFilterWhere([
                'i.publisherId' => $filter->publisherId,
                'i.rating' => $filter->rating
            ]);

        if ($filter->yearFrom !== null) {
            $q->andWhere(['>=', 'i.publishYear', $filter->yearFrom]);
        }

        if ($filter->yearTo !== null) {
            $q->andWhere(['<=', 'i.publishYear', $filter->yearTo]);
        }

        if ($needAuthorJoin) {
            $q->innerJoin(['ia' => 'item_author'], 'ia.itemId = i.id')
                ->innerJoin(['a' => 'author'], 'a.id = ia.authorId')
                ->andWhere(['like', 'a.name', $filter->authorName]);
        }

        if ($needGenreJoin) {
            $q->innerJoin(['ig' => 'item_genre'], 'ig.itemId = i.id')
                ->andWhere(['ig.genreId' => $filter->genreId]);
        }

        // Count (distinct in case of joins)
        $countQuery = clone $q;
        $total = (int)$countQuery->select(new Expression('COUNT(DISTINCT i.id)'))->scalar();

        $q->orderBy([$sortBy => $sortDirection])
            ->offset($offset)
            ->limit($filter->pageSize)
            ->groupBy('i.id');

        /** @var Item[] $items */
        $items = $q->all();
        return new ItemSearchResult($items, $total, $filter->page, $filter->pageSize);
    }

    /**
     * @throws Exception
     */
    public function replaceAuthors(int $itemId, array $authorIds = []): void {
        $db = Yii::$app->db;
        $db->createCommand()
            ->delete('item_author', ['itemId' => $itemId])
            ->execute();

        if ($authorIds) {
            $rows = array_map(static fn(int $aid) => [$itemId, $aid], $authorIds);
            $db->createCommand()
                ->batchInsert('item_author', ['itemId', 'authorId'], $rows)
                ->execute();
        }
    }

    /**
     * @throws Exception
     */
    public function replaceGenres(int $itemId, array $genreIds = []): void {
        $db = Yii::$app->db;
        $db->createCommand()
            ->delete('item_genre', ['itemId' => $itemId])
            ->execute();

        if ($genreIds) {
            $rows = array_map(static fn(int $gid) => [$itemId, $gid], $genreIds);
            $db->createCommand()
                ->batchInsert('item_genre', ['itemId', 'genreId'], $rows)
                ->execute();
        }
    }
}
