<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Controller;

use Codices\Model\Account;
use yii\web\Response;

final class AccountController {

    public function index(CurrentRoute $currentRoute): string {
        $query = Account::find()->orderBy(['username' => SORT_ASC]);
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
        $account = Account::findOne(['id' => $id]);

        if ($account === null) {
            return $this->viewRenderer->renderWithStatus('_404', [], 404);
        }

        return $this->viewRenderer->render('view', [
            'account' => $account,
        ]);
    }

    public function create(ValidatorInterface $validator): Response|string {
        $account = new Account();
        $method = $this->request->getMethod();
        $errors = [];

        if ($method === Method::POST) {
            $body = $this->request->getParsedBody();
            $account->setAttributes($body);

            $errors = $validator->validate($account);
            if (empty($errors)) {
                $account->generateAuthKey();
                if ($account->save()) {
                    return $this->response->withStatus(302)->withHeader('Location', '/account/view/' . $account->id);
                }
            }
        }

        return $this->viewRenderer->render('create', [
            'account' => $account,
            'errors' => $errors,
        ]);
    }

    public function update(CurrentRoute $currentRoute, ValidatorInterface $validator): Response|string {
        $id = $currentRoute->getArgument('id');
        $account = Account::findOne(['id' => $id]);

        if ($account === null) {
            return $this->viewRenderer->renderWithStatus('_404', [], 404);
        }

        $method = $this->request->getMethod();
        $errors = [];

        if ($method === Method::POST) {
            $body = $this->request->getParsedBody();
            $account->setAttributes($body);

            $errors = $validator->validate($account);
            if (empty($errors)) {
                if ($account->save()) {
                    return $this->response->withStatus(302)->withHeader('Location', '/account/view/' . $account->id);
                }
            }
        }

        return $this->viewRenderer->render('update', [
            'account' => $account,
            'errors' => $errors,
        ]);
    }

    public function delete(CurrentRoute $currentRoute): Response|string {
        $id = $currentRoute->getArgument('id');
        $account = Account::findOne(['id' => $id]);

        if ($account !== null) {
            $account->delete();
        }

        return $this->response->withStatus(302)->withHeader('Location', '/account');
    }

    public function profile(): Response|string {
        // Get current user account
        $account = Account::findOne(['id' => $this->user->getId()]);

        return $this->viewRenderer->render('profile', [
            'account' => $account,
        ]);
    }
}
