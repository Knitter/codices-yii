<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Controller;

use Codices\Model\Author;
use yii\web\Response;

final class AuthorController {

    public function index(CurrentRoute $currentRoute): Response|string {
        $query = Author::find()->orderBy(['name' => Sort::SORT_ASC, 'surname' => Sort::SORT_ASC]);
        $paginator = (new OffsetPaginator($query))
            ->withPageSize(10)
            ->withCurrentPage((int)$currentRoute->getArgument('page', '1'));

        return $this->viewRenderer->render('index', [
            'paginator' => $paginator,
        ]);
    }

    public function view(CurrentRoute $currentRoute): Response|string {
        $id = $currentRoute->getArgument('id');
        $author = Author::findOne(['id' => $id]);

        if ($author === null) {
            return $this->viewRenderer->renderWithStatus('_404', [], 404);
        }

        return $this->viewRenderer->render('view', [
            'author' => $author,
        ]);
    }

    public function create(ValidatorInterface $validator): Response|string {
        $author = new Author();
        $method = $this->request->getMethod();
        $errors = [];

        if ($method === Method::POST) {
            $body = $this->request->getParsedBody();
            $author->setAttributes($body);

            // Set the owner ID to the current user
            $author->ownedById = 1; // This should be replaced with the current user ID

            $errors = $validator->validate($author);
            if (empty($errors)) {
                if ($author->save()) {
                    return $this->response->withStatus(302)->withHeader('Location', '/author/view/' . $author->id);
                }
            }
        }

        return $this->viewRenderer->render('create', [
            'author' => $author,
            'errors' => $errors,
        ]);
    }

    public function update(CurrentRoute $currentRoute, ValidatorInterface $validator): Response|string {
        $id = $currentRoute->getArgument('id');
        $author = Author::findOne(['id' => $id]);

        if ($author === null) {
            return $this->viewRenderer->renderWithStatus('_404', [], 404);
        }

        $method = $this->request->getMethod();
        $errors = [];

        if ($method === Method::POST) {
            $body = $this->request->getParsedBody();
            $author->setAttributes($body);

            $errors = $validator->validate($author);
            if (empty($errors)) {
                if ($author->save()) {
                    return $this->response->withStatus(302)->withHeader('Location', '/author/view/' . $author->id);
                }
            }
        }

        return $this->viewRenderer->render('update', [
            'author' => $author,
            'errors' => $errors,
        ]);
    }

    public function delete(CurrentRoute $currentRoute): Response|string {
        $id = $currentRoute->getArgument('id');
        $author = Author::findOne(['id' => $id]);

        if ($author !== null) {
            $author->delete();
        }

        return $this->response->withStatus(302)->withHeader('Location', '/author');
    }
}
