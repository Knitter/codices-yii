<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Controller;

use Codices\Model\Publisher;
use yii\web\Response;

final class PublisherController {

    public function index(CurrentRoute $currentRoute): Response|string {
        $query = Publisher::find()->orderBy(['name' => Sort::SORT_ASC]);
        $paginator = (new OffsetPaginator($query))
            ->withPageSize(10)
            ->withCurrentPage((int)$currentRoute->getArgument('page', '1'));

        return $this->viewRenderer->render('index', [
            'paginator' => $paginator,
            'currentRoute' => $currentRoute,
        ]);
    }

    public function view(CurrentRoute $currentRoute): Response|string {
        $id = $currentRoute->getArgument('id');
        $publisher = Publisher::findOne(['id' => $id]);

        if ($publisher === null) {
            return $this->viewRenderer->renderWithStatus('_404', [], 404);
        }

        return $this->viewRenderer->render('view', [
            'publisher' => $publisher,
        ]);
    }

    public function create(ValidatorInterface $validator): Response|string {
        $publisher = new Publisher();
        $method = $this->request->getMethod();
        $errors = [];

        if ($method === Method::POST) {
            $body = $this->request->getParsedBody();
            $publisher->setAttributes($body);

            // Set the owner ID to the current user
            $publisher->ownedById = 1; // This should be replaced with the current user ID

            $errors = $validator->validate($publisher);
            if (empty($errors)) {
                if ($publisher->save()) {
                    return $this->response->withStatus(302)->withHeader('Location', '/publisher/view/' . $publisher->id);
                }
            }
        }

        return $this->viewRenderer->render('create', [
            'publisher' => $publisher,
            'errors' => $errors,
        ]);
    }

    public function update(CurrentRoute $currentRoute, ValidatorInterface $validator): Response|string {
        $id = $currentRoute->getArgument('id');
        $publisher = Publisher::findOne(['id' => $id]);

        if ($publisher === null) {
            return $this->viewRenderer->renderWithStatus('_404', [], 404);
        }

        $method = $this->request->getMethod();
        $errors = [];

        if ($method === Method::POST) {
            $body = $this->request->getParsedBody();
            $publisher->setAttributes($body);

            $errors = $validator->validate($publisher);
            if (empty($errors)) {
                if ($publisher->save()) {
                    return $this->response->withStatus(302)->withHeader('Location', '/publisher/view/' . $publisher->id);
                }
            }
        }

        return $this->viewRenderer->render('update', [
            'publisher' => $publisher,
            'errors' => $errors,
        ]);
    }

    public function delete(CurrentRoute $currentRoute): Response|string {
        $id = $currentRoute->getArgument('id');
        $publisher = Publisher::findOne(['id' => $id]);

        if ($publisher !== null) {
            $publisher->delete();
        }

        return $this->response->withStatus(302)->withHeader('Location', '/publisher');
    }
}
