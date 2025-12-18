<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Controller;

use Codices\Model\Author;
use Codices\Model\Collection;
use Codices\Model\Genre;
use Codices\Model\Item;
use Codices\Model\ItemAuthor;
use Codices\Model\ItemGenre;
use Codices\Model\Publisher;
use Codices\Model\Series;
use yii\web\Response;

final class ItemController extends CodicesController{

    public function index(CurrentRoute $currentRoute): Response|string {
        $query = Item::find()->orderBy(['title' => Sort::SORT_ASC]);
        $paginator = (new OffsetPaginator($query))
            ->withPageSize(10)
            ->withCurrentPage((int)$currentRoute->getArgument('page', '1'));

        return $this->viewRenderer->render('index', [
            'paginator' => $paginator,
            'itemTypes' => Item::getTypes(),
        ]);
    }

    public function books(CurrentRoute $currentRoute): Response|string {
        $query = Item::find()
            ->where(['type' => Item::TYPE_PAPER])
            ->orderBy(['title' => Sort::SORT_ASC]);

        $paginator = (new OffsetPaginator($query))
            ->withPageSize(10)
            ->withCurrentPage((int)$currentRoute->getArgument('page', '1'));

        return $this->viewRenderer->render('books', [
            'paginator' => $paginator,
        ]);
    }

    public function ebooks(CurrentRoute $currentRoute): Response|string {
        $query = Item::find()
            ->where(['type' => Item::TYPE_EBOOK])
            ->orderBy(['title' => Sort::SORT_ASC]);

        $paginator = (new OffsetPaginator($query))
            ->withPageSize(10)
            ->withCurrentPage((int)$currentRoute->getArgument('page', '1'));

        return $this->viewRenderer->render('ebooks', [
            'paginator' => $paginator,
        ]);
    }

    public function audiobooks(CurrentRoute $currentRoute): Response|string {
        $query = Item::find()
            ->where(['type' => Item::TYPE_AUDIO])
            ->orderBy(['title' => Sort::SORT_ASC]);

        $paginator = (new OffsetPaginator($query))
            ->withPageSize(10)
            ->withCurrentPage((int)$currentRoute->getArgument('page', '1'));

        return $this->viewRenderer->render('audiobooks', [
            'paginator' => $paginator,
        ]);
    }

    public function view(CurrentRoute $currentRoute): Response|string {
        $id = $currentRoute->getArgument('id');
        $item = Item::findOne(['id' => $id]);

        if ($item === null) {
            return $this->viewRenderer->renderWithStatus('_404', [], 404);
        }

        return $this->viewRenderer->render('view', [
            'item' => $item,
            'itemTypes' => Item::getTypes(),
        ]);
    }

    public function create(ValidatorInterface $validator): Response|string {
        $item = new Item();
        $method = $this->request->getMethod();
        $errors = [];

        // Get lists for dropdowns
        $publishers = Publisher::find()->orderBy(['name' => Sort::SORT_ASC])->all();
        $series = Series::find()->orderBy(['name' => Sort::SORT_ASC])->all();
        $collections = Collection::find()->orderBy(['name' => Sort::SORT_ASC])->all();
        $authors = Author::find()->orderBy(['name' => Sort::SORT_ASC, 'surname' => Sort::SORT_ASC])->all();
        $genres = Genre::find()->orderBy(['name' => Sort::SORT_ASC])->all();

        if ($method === Method::POST) {
            $body = $this->request->getParsedBody();
            $item->setAttributes($body);

            // Set the owner ID to the current user
            $item->ownedById = 1; // This should be replaced with the current user ID

            // Set default values
            if (empty($item->copies)) {
                $item->copies = 1;
            }
            if (empty($item->addedOn)) {
                $item->addedOn = date('Y-m-d');
            }

            $errors = $validator->validate($item);
            if (empty($errors)) {
                if ($item->save()) {
                    // Save authors
                    if (isset($body['authors']) && is_array($body['authors'])) {
                        foreach ($body['authors'] as $authorId) {
                            $itemAuthor = new ItemAuthor();
                            $itemAuthor->itemId = $item->id;
                            $itemAuthor->authorId = $authorId;
                            $itemAuthor->save();
                        }
                    }

                    // Save genres
                    if (isset($body['genres']) && is_array($body['genres'])) {
                        foreach ($body['genres'] as $genreId) {
                            $itemGenre = new ItemGenre();
                            $itemGenre->itemId = $item->id;
                            $itemGenre->genreId = $genreId;
                            $itemGenre->save();
                        }
                    }

                    return $this->response->withStatus(302)->withHeader('Location', '/item/view/' . $item->id);
                }
            }
        }

        return $this->viewRenderer->render('create', [
            'item' => $item,
            'errors' => $errors,
            'itemTypes' => Item::getTypes(),
            'publishers' => $publishers,
            'series' => $series,
            'collections' => $collections,
            'authors' => $authors,
            'genres' => $genres,
        ]);
    }

    public function update(CurrentRoute $currentRoute, ValidatorInterface $validator): Response|string {
        $id = $currentRoute->getArgument('id');
        $item = Item::findOne(['id' => $id]);

        if ($item === null) {
            return $this->viewRenderer->renderWithStatus('_404', [], 404);
        }

        $method = $this->request->getMethod();
        $errors = [];

        // Get lists for dropdowns
        $publishers = Publisher::find()->orderBy(['name' => Sort::SORT_ASC])->all();
        $series = Series::find()->orderBy(['name' => Sort::SORT_ASC])->all();
        $collections = Collection::find()->orderBy(['name' => Sort::SORT_ASC])->all();
        $authors = Author::find()->orderBy(['name' => Sort::SORT_ASC, 'surname' => Sort::SORT_ASC])->all();
        $genres = Genre::find()->orderBy(['name' => Sort::SORT_ASC])->all();

        // Get current authors and genres
        $selectedAuthors = array_map(fn($author) => $author->id, $item->getAuthors()->all());
        $selectedGenres = array_map(fn($genre) => $genre->id, $item->getGenres()->all());

        if ($method === Method::POST) {
            $body = $this->request->getParsedBody();
            $item->setAttributes($body);

            $errors = $validator->validate($item);
            if (empty($errors)) {
                if ($item->save()) {
                    // Update authors
                    ItemAuthor::deleteAll(['itemId' => $item->id]);
                    if (isset($body['authors']) && is_array($body['authors'])) {
                        foreach ($body['authors'] as $authorId) {
                            $itemAuthor = new ItemAuthor();
                            $itemAuthor->itemId = $item->id;
                            $itemAuthor->authorId = $authorId;
                            $itemAuthor->save();
                        }
                    }

                    // Update genres
                    ItemGenre::deleteAll(['itemId' => $item->id]);
                    if (isset($body['genres']) && is_array($body['genres'])) {
                        foreach ($body['genres'] as $genreId) {
                            $itemGenre = new ItemGenre();
                            $itemGenre->itemId = $item->id;
                            $itemGenre->genreId = $genreId;
                            $itemGenre->save();
                        }
                    }

                    return $this->response->withStatus(302)->withHeader('Location', '/item/view/' . $item->id);
                }
            }
        }

        return $this->viewRenderer->render('update', [
            'item' => $item,
            'errors' => $errors,
            'itemTypes' => Item::getTypes(),
            'publishers' => $publishers,
            'series' => $series,
            'collections' => $collections,
            'authors' => $authors,
            'genres' => $genres,
            'selectedAuthors' => $selectedAuthors,
            'selectedGenres' => $selectedGenres,
        ]);
    }

    public function delete(CurrentRoute $currentRoute): Response|string {
        $id = $currentRoute->getArgument('id');
        $item = Item::findOne(['id' => $id]);

        if ($item !== null) {
            // Delete related records first
            ItemAuthor::deleteAll(['itemId' => $item->id]);
            ItemGenre::deleteAll(['itemId' => $item->id]);

            $item->delete();
        }

        return $this->response->withStatus(302)->withHeader('Location', '/item');
    }

    public function search(): Response|string {
        $query = null;
        $results = [];
        $searchTerm = $this->request->getQueryParams()['q'] ?? '';

        if (!empty($searchTerm)) {
            $query = Item::find()
                ->where(['like', 'title', $searchTerm])
                ->orWhere(['like', 'subtitle', $searchTerm])
                ->orWhere(['like', 'originalTitle', $searchTerm])
                ->orWhere(['like', 'plot', $searchTerm])
                ->orWhere(['like', 'isbn', $searchTerm])
                ->orderBy(['title' => Sort::SORT_ASC]);

            $results = $query->all();
        }

        return $this->viewRenderer->render('search', [
            'results' => $results,
            'searchTerm' => $searchTerm,
            'itemTypes' => Item::getTypes(),
        ]);
    }
}
