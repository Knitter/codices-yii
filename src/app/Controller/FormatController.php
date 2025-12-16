<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Controller;

use Codices\Model\Format;
use yii\web\Response;

final class FormatController {

    public function index(CurrentRoute $currentRoute): Response|string {
        $query = Format::find()->orderBy(['type' => Sort::SORT_ASC, 'name' => Sort::SORT_ASC]);
        $paginator = (new OffsetPaginator($query))
            ->withPageSize(10)
            ->withCurrentPage((int)$currentRoute->getArgument('page', '1'));

        return $this->viewRenderer->render('index', [
            'paginator' => $paginator,
            'formatTypes' => Format::getFormatTypes(),
        ]);
    }

    public function view(CurrentRoute $currentRoute): Response|string {
        $type = $currentRoute->getArgument('type');
        $name = $currentRoute->getArgument('name');
        $ownedById = $currentRoute->getArgument('ownedById', '1'); // Default to user 1 for now

        $format = Format::findOne(['type' => $type, 'name' => $name, 'ownedById' => $ownedById]);

        if ($format === null) {
            return $this->viewRenderer->renderWithStatus('_404', [], 404);
        }

        return $this->viewRenderer->render('view', [
            'format' => $format,
            'formatTypes' => Format::getFormatTypes(),
        ]);
    }

    public function create(ValidatorInterface $validator): Response|string {
        $format = new Format();
        $method = $this->request->getMethod();
        $errors = [];

        if ($method === Method::POST) {
            $body = $this->request->getParsedBody();
            $format->setAttributes($body);

            // Set the owner ID to the current user
            $format->ownedById = 1; // This should be replaced with the current user ID

            $errors = $validator->validate($format);
            if (empty($errors)) {
                if ($format->save()) {
                    return $this->response->withStatus(302)->withHeader(
                        'Location',
                        '/format/view/' . $format->type . '/' . $format->name . '/' . $format->ownedById
                    );
                }
            }
        }

        return $this->viewRenderer->render('create', [
            'format' => $format,
            'errors' => $errors,
            'formatTypes' => Format::getFormatTypes(),
        ]);
    }

    public function update(CurrentRoute $currentRoute, ValidatorInterface $validator): Response|string {
        $type = $currentRoute->getArgument('type');
        $name = $currentRoute->getArgument('name');
        $ownedById = $currentRoute->getArgument('ownedById', '1'); // Default to user 1 for now

        $format = Format::findOne(['type' => $type, 'name' => $name, 'ownedById' => $ownedById]);

        if ($format === null) {
            return $this->viewRenderer->renderWithStatus('_404', [], 404);
        }

        $method = $this->request->getMethod();
        $errors = [];

        if ($method === Method::POST) {
            $body = $this->request->getParsedBody();
            $format->setAttributes($body);

            $errors = $validator->validate($format);
            if (empty($errors)) {
                if ($format->save()) {
                    return $this->response->withStatus(302)->withHeader(
                        'Location',
                        '/format/view/' . $format->type . '/' . $format->name . '/' . $format->ownedById
                    );
                }
            }
        }

        return $this->viewRenderer->render('update', [
            'format' => $format,
            'errors' => $errors,
            'formatTypes' => Format::getFormatTypes(),
        ]);
    }

    public function delete(CurrentRoute $currentRoute): Response {
        $type = $currentRoute->getArgument('type');
        $name = $currentRoute->getArgument('name');
        $ownedById = $currentRoute->getArgument('ownedById', '1'); // Default to user 1 for now

        $format = Format::findOne(['type' => $type, 'name' => $name, 'ownedById' => $ownedById]);

        if ($format !== null) {
            $format->delete();
        }

        return $this->response->withStatus(302)->withHeader('Location', '/format');
    }
}
