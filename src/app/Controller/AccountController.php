<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Controller;

use Codices\Service\AccountService;
use Codices\View\Facade\Account;
use Codices\View\Model\AccountSearch;
use Yii;
use yii\web\Response;

final class AccountController extends CodicesController {

    public function __construct($id, $module, private readonly AccountService $accountService, $config = []) {
        parent::__construct($id, $module, $config);
    }

    public function index(): Response|string {
        $searchModel = new AccountSearch();
        $dataProvider = $searchModel->search($this->accountService, Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function view(): Response|string {
        $id = (int)Yii::$app->request->get('id');
        $account = $this->accountService->findById($id);
        if ($account === null) {
            return $this->asJson(['message' => 'Not found'])->setStatusCode(404);
        }

        return $this->render('view', [
            'account' => $account,
        ]);
    }

    public function add(): Response|string {
        $form = new Account();
        $request = Yii::$app->request;
        if ($request->isPost) {
            $form->setAttributes($request->post());
            $form->active = (bool)$request->post('active', $form->active);
            if ($form->validate()) {
                $this->accountService->create($form);
                return $this->redirect(['/account/index']);
            }
        }

        return $this->render('add', [
            'model' => $form,
            'csrf' => Yii::$app->request->getCsrfToken(),
        ]);
    }

    public function edit(): Response|string {
        $id = (int)Yii::$app->request->get('id');
        $account = $this->accountService->findById($id);
        if ($account === null) {
            return $this->asJson(['message' => 'Not found'])->setStatusCode(404);
        }

        $form = new Account();
        $form->loadFromAccount($account);

        $request = Yii::$app->request;
        if ($request->isPost) {
            $form->setAttributes($request->post());
            $form->active = (bool)$request->post('active', $form->active);
            if ($form->validate()) {
                $this->accountService->update($id, $form);
                return $this->redirect(['/account/index']);
            }
        }

        return $this->render('edit', [
            'model' => $form,
            'accountId' => $id
        ]);
    }

    public function delete(): Response|string {
        $id = (int)Yii::$app->request->get('id');
        $this->accountService->delete($id);
        return $this->redirect(['/account/index']);
    }
}
