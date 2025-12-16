<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Controller;

use Codices\Model\Collection;
use yii\web\Response;

final class CollectionController {

    public function index(CurrentRoute $currentRoute): Response|string {
        $query = Collection::find()->orderBy(['name' => Sort::SORT_ASC]);
        $paginator = (new OffsetPaginator($query))
            ->withPageSize(10)
            ->withCurrentPage((int)$currentRoute->getArgument('page', '1'));

        return $this->viewRenderer->render('index', [
            'paginator' => $paginator,
        ]);
    }

    public function view(CurrentRoute $currentRoute): Response|string {
        $id = $currentRoute->getArgument('id');
        $collection = Collection::findOne(['id' => $id]);

        if ($collection === null) {
            return $this->viewRenderer->renderWithStatus('_404', [], 404);
        }

        return $this->viewRenderer->render('view', [
            'collection' => $collection,
        ]);
    }

    public function create(ValidatorInterface $validator): Response|string {
        $collection = new Collection();
        $method = $this->request->getMethod();
        $errors = [];

        if ($method === Method::POST) {
            $body = $this->request->getParsedBody();
            $collection->setAttributes($body);

            // Set the owner ID to the current user
            $collection->ownedById = 1; // This should be replaced with the current user ID

            $errors = $validator->validate($collection);
            if (empty($errors)) {
                if ($collection->save()) {
                    return $this->response->withStatus(302)->withHeader('Location', '/collection/view/' . $collection->id);
                }
            }
        }

        return $this->viewRenderer->render('create', [
            'collection' => $collection,
            'errors' => $errors,
        ]);
    }

    public function update(CurrentRoute $currentRoute, ValidatorInterface $validator): Response|string {
        $id = $currentRoute->getArgument('id');
        $collection = Collection::findOne(['id' => $id]);

        if ($collection === null) {
            return $this->viewRenderer->renderWithStatus('_404', [], 404);
        }

        $method = $this->request->getMethod();
        $errors = [];

        if ($method === Method::POST) {
            $body = $this->request->getParsedBody();
            $collection->setAttributes($body);

            $errors = $validator->validate($collection);
            if (empty($errors)) {
                if ($collection->save()) {
                    return $this->response->withStatus(302)->withHeader('Location', '/collection/view/' . $collection->id);
                }
            }
        }

        return $this->viewRenderer->render('update', [
            'collection' => $collection,
            'errors' => $errors,
        ]);
    }

    public function delete(CurrentRoute $currentRoute): Response|string {
        $id = $currentRoute->getArgument('id');
        $collection = Collection::findOne(['id' => $id]);

        if ($collection !== null) {
            $collection->delete();
        }

        return $this->response->withStatus(302)->withHeader('Location', '/collection');
    }
}
