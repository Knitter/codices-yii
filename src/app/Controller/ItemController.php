<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Controller;

use Codices\Model\Item;
use Codices\Query\ItemFilter;
use Codices\Service\ItemService;
use Codices\Service\SearchService;
use Yii;
use yii\web\Response;

final class ItemController extends CodicesController {

    public function __construct(
        $id,
        $module,
        private readonly SearchService $searchService,
        private readonly ItemService   $itemService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
    }

    public function index(): Response|string {
        return $this->renderBooksByType(null);
    }

    public function books(): Response|string {
        return $this->renderBooksByType(Item::TYPE_PAPER);
    }

    public function ebooks(): Response|string {
        return $this->renderBooksByType(Item::TYPE_EBOOK);
    }

    public function audiobooks(): Response|string {
        return $this->renderBooksByType(Item::TYPE_AUDIO);
    }

    public function view(): Response|string {
        $id = (int)Yii::$app->request->get('id');
        $item = Item::findOne(['id' => $id]);
        if ($item === null) {
            return $this->asJson(['message' => 'Not found'])->setStatusCode(404);
        }
        // Reuse book edit page as details/editor
        return $this->redirect(['/book/edit', 'id' => $id]);
    }

    public function add(): Response|string {
        // Delegate to BookController which contains the full BookForm flow
        return $this->redirect(['/book/add']);
    }

    public function edit(): Response|string {
        $id = (int)Yii::$app->request->get('id');
        return $this->redirect(['/book/edit', 'id' => $id]);
    }

    public function delete(): Response|string {
        $id = (int)Yii::$app->request->get('id');
        $this->itemService->delete($id);
        return $this->redirect(['/book/index']);
    }

    private function renderBooksByType(?string $type): Response|string {
        $queryParams = Yii::$app->request->get();
        if ($type !== null) {
            $queryParams['type'] = $type;
        }
        $filter = ItemFilter::fromArray($queryParams);
        $result = $this->searchService->searchItems($filter);

        $sortOrder = $queryParams['sort'] ?? 'title';
        $sortDirection = $queryParams['sort_dir'] ?? 'asc';
        $sort = [
            'title' => [
                'asc' => ['title' => SORT_ASC],
                'desc' => ['title' => SORT_DESC],
            ],
            'publishYear' => [
                'asc' => ['publishYear' => SORT_ASC],
                'desc' => ['publishYear' => SORT_DESC],
            ],
            'rating' => [
                'asc' => ['rating' => SORT_ASC],
                'desc' => ['rating' => SORT_DESC],
            ],
            'addedOn' => [
                'asc' => ['addedOn' => SORT_ASC],
                'desc' => ['addedOn' => SORT_DESC],
            ],
        ];

        $paginator = [
            'items' => $result->items,
            'total' => $result->total,
            'page' => $result->page,
            'pageSize' => $result->pageSize,
        ];

        // Reuse the existing Book index view, which already renders listings/filters
        return $this->render('//book/index', [
            'paginator' => $paginator,
            'queryParams' => $queryParams,
            'sort' => $sort,
            'currentSort' => $sortOrder,
            'currentDirection' => $sortDirection,
        ]);
    }
}
