<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Controller;

use Codices\Model\Genre;
use yii\web\Response;

final class GenreController {

    public function index(CurrentRoute $currentRoute): Response|string {
        $query = Genre::find()->orderBy(['name' => Sort::SORT_ASC]);
        $paginator = (new OffsetPaginator($query))
            ->withPageSize(10)
            ->withCurrentPage((int)$currentRoute->getArgument('page', '1'));

        return $this->viewRenderer->render('index', [
            'paginator' => $paginator,
        ]);
    }

    public function view(CurrentRoute $currentRoute): Response|string {
        $id = $currentRoute->getArgument('id');
        $genre = Genre::findOne(['id' => $id]);

        if ($genre === null) {
            return $this->viewRenderer->renderWithStatus('_404', [], 404);
        }

        return $this->viewRenderer->render('view', [
            'genre' => $genre,
        ]);
    }

    public function create(ValidatorInterface $validator): Response|string {
        $genre = new Genre();
        $method = $this->request->getMethod();
        $errors = [];

        if ($method === Method::POST) {
            $body = $this->request->getParsedBody();
            $genre->setAttributes($body);

            // Set the owner ID to the current user
            $genre->ownedById = 1; // This should be replaced with the current user ID

            $errors = $validator->validate($genre);
            if (empty($errors)) {
                if ($genre->save()) {
                    return $this->response->withStatus(302)->withHeader('Location', '/genre/view/' . $genre->id);
                }
            }
        }

        return $this->viewRenderer->render('create', [
            'genre' => $genre,
            'errors' => $errors,
        ]);
    }

    public function update(CurrentRoute $currentRoute, ValidatorInterface $validator): Response|string {
        $id = $currentRoute->getArgument('id');
        $genre = Genre::findOne(['id' => $id]);

        if ($genre === null) {
            return $this->viewRenderer->renderWithStatus('_404', [], 404);
        }

        $method = $this->request->getMethod();
        $errors = [];

        if ($method === Method::POST) {
            $body = $this->request->getParsedBody();
            $genre->setAttributes($body);

            $errors = $validator->validate($genre);
            if (empty($errors)) {
                if ($genre->save()) {
                    return $this->response->withStatus(302)->withHeader('Location', '/genre/view/' . $genre->id);
                }
            }
        }

        return $this->viewRenderer->render('update', [
            'genre' => $genre,
            'errors' => $errors,
        ]);
    }

    public function delete(CurrentRoute $currentRoute): Response|string {
        $id = $currentRoute->getArgument('id');
        $genre = Genre::findOne(['id' => $id]);

        if ($genre !== null) {
            $genre->delete();
        }

        return $this->response->withStatus(302)->withHeader('Location', '/genre');
    }
}
