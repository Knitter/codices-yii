<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Controller;

use Codices\Model\Series;
use yii\web\Response;

final class SeriesController {

    public function index(CurrentRoute $currentRoute): Response|string {
        $query = Series::find()->orderBy(['name' => Sort::SORT_ASC]);
        $paginator = (new OffsetPaginator($query))
            ->withPageSize(10)
            ->withCurrentPage((int)$currentRoute->getArgument('page', '1'));

        return $this->viewRenderer->render('index', [
            'paginator' => $paginator,
        ]);
    }

    public function view(CurrentRoute $currentRoute): Response|string {
        $id = $currentRoute->getArgument('id');
        $series = Series::findOne(['id' => $id]);

        if ($series === null) {
            return $this->viewRenderer->renderWithStatus('_404', [], 404);
        }

        return $this->viewRenderer->render('view', [
            'series' => $series,
        ]);
    }

    public function create(ValidatorInterface $validator): Response|string {
        $series = new Series();
        $method = $this->request->getMethod();
        $errors = [];

        if ($method === Method::POST) {
            $body = $this->request->getParsedBody();
            $series->setAttributes($body);

            // Set the owner ID to the current user
            $series->ownedById = 1; // This should be replaced with the current user ID

            $errors = $validator->validate($series);
            if (empty($errors)) {
                if ($series->save()) {
                    return $this->response->withStatus(302)->withHeader('Location', '/series/view/' . $series->id);
                }
            }
        }

        return $this->viewRenderer->render('create', [
            'series' => $series,
            'errors' => $errors,
        ]);
    }

    public function update(CurrentRoute $currentRoute, ValidatorInterface $validator): Response|string {
        $id = $currentRoute->getArgument('id');
        $series = Series::findOne(['id' => $id]);

        if ($series === null) {
            return $this->viewRenderer->renderWithStatus('_404', [], 404);
        }

        $method = $this->request->getMethod();
        $errors = [];

        if ($method === Method::POST) {
            $body = $this->request->getParsedBody();
            $series->setAttributes($body);

            $errors = $validator->validate($series);
            if (empty($errors)) {
                if ($series->save()) {
                    return $this->response->withStatus(302)->withHeader('Location', '/series/view/' . $series->id);
                }
            }
        }

        return $this->viewRenderer->render('update', [
            'series' => $series,
            'errors' => $errors,
        ]);
    }

    public function delete(CurrentRoute $currentRoute): Response|string {
        $id = $currentRoute->getArgument('id');
        $series = Series::findOne(['id' => $id]);

        if ($series !== null) {
            $series->delete();
        }

        return $this->response->withStatus(302)->withHeader('Location', '/series');
    }
}
