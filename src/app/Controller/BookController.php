<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Controller;

use Codices\Model\Author;
use Codices\Model\Collection;
use Codices\Model\Format;
use Codices\Model\Genre;
use Codices\Model\Item;
use Codices\Model\ItemAuthor;
use Codices\Model\ItemGenre;
use Codices\Model\Publisher;
use Codices\Model\Series;
use Codices\Query\ItemFilter;
use Codices\Service\ItemService;
use Codices\Service\SearchService;
use Codices\View\Facade\BookForm;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;

final class BookController extends CodicesController {

    public function __construct($id, $module, private readonly SearchService $searchService,
                                private readonly ItemService $itemService, $config = []) {
        parent::__construct($id, $module, $config);
    }

    public function index(): Response|string {
        $queryParams = Yii::$app->request->get();
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

        //TODO: Load related and filter-support data
        $genres = [];//Genre::find()->orderBy('name')->all();
        $publishers = [];//Publisher::find()->orderBy('name')->all();

        return $this->render('index', [
            'paginator' => $paginator,
            'queryParams' => $queryParams,
            //'genres' => $genres,
            //'publishers' => $publishers,
            'sort' => $sort,
            'currentSort' => $sortOrder,
            'currentDirection' => $sortDirection,
        ]);
    }

    public function add(): Response|string {

        $form = new BookForm();

        // Lookups
        $authors = ArrayHelper::map(Author::find()->orderBy('name')->all(), 'id', 'name');
        $genres = ArrayHelper::map(Genre::find()->orderBy('name')->all(), 'id', 'name');
        $publishers = ArrayHelper::map(Publisher::find()->orderBy('name')->all(), 'id', 'name');
        $series = ArrayHelper::map(Series::find()->orderBy('name')->all(), 'id', 'name');
        $collections = ArrayHelper::map(Collection::find()->orderBy('name')->all(), 'id', 'name');
        $formats = ArrayHelper::map(Format::find()->orderBy('name')->all(), 'name', 'name');

        $request = Yii::$app->request;
        if ($request->isPost) {
            // Accept legacy flat POST names (no model prefix)
            $form->setAttributes($request->post());

            $form->authors = (array)$request->post('authors', $form->authors);
            $form->genres = (array)$request->post('genres', $form->genres);
            $form->translated = (bool)$request->post('translated', $form->translated);
            $form->read = (bool)$request->post('read', $form->read);
            if ($form->validate()) {
                $ownerId = 1; // TODO: from auth
                $this->itemService->create($form, $ownerId);
                return $this->redirect(['/book/index']);
            }
        }

        return $this->render('add', [
            'model' => $form,
            'authors' => $authors,
            'genres' => $genres,
            'publishers' => $publishers,
            'series' => $series,
            'collections' => $collections,
            'formats' => $formats,
            'csrf' => Yii::$app->request->getCsrfToken(),
        ]);
    }

    public function edit(): Response|string {
        $id = (int)Yii::$app->request->get('id');
        $item = Item::findOne(['id' => $id]);
        if ($item === null) {
            return $this->asJson(['message' => 'Not found'])->setStatusCode(404);
        }

        $form = new BookForm();
        $form->loadFromItem($item);

        // prefill authors/genres
        $form->authors = array_map(static fn($a) => (int)$a['id'], $item->getAuthors()->select('id')->asArray()->all());
        $form->genres = array_map(static fn($g) => (int)$g['id'], $item->getGenres()->select('id')->asArray()->all());

        // Lookups
        $authors = ArrayHelper::map(Author::find()->orderBy('name')->all(), 'id', 'name');
        $genres = ArrayHelper::map(Genre::find()->orderBy('name')->all(), 'id', 'name');
        $publishers = ArrayHelper::map(Publisher::find()->orderBy('name')->all(), 'id', 'name');
        $series = ArrayHelper::map(Series::find()->orderBy('name')->all(), 'id', 'name');
        $collections = ArrayHelper::map(Collection::find()->orderBy('name')->all(), 'id', 'name');
        $formats = ArrayHelper::map(Format::find()->orderBy('name')->all(), 'name', 'name');

        $request = Yii::$app->request;
        if ($request->isPost) {
            $form->setAttributes($request->post());
            $form->authors = (array)$request->post('authors', $form->authors);
            $form->genres = (array)$request->post('genres', $form->genres);
            $form->translated = (bool)$request->post('translated', $form->translated);
            $form->read = (bool)$request->post('read', $form->read);
            if ($form->validate()) {
                $ownerId = 1; // TODO: from auth
                $this->itemService->update($id, $form, $ownerId);
                return $this->redirect(['/book/index']);
            }
        }

        return $this->render('edit', [
            'model' => $form,
            'authors' => $authors,
            'genres' => $genres,
            'publishers' => $publishers,
            'series' => $series,
            'collections' => $collections,
            'formats' => $formats,
            'itemId' => $id,
            'csrf' => Yii::$app->request->getCsrfToken(),
        ]);
    }
}
