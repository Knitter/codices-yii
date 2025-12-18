<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Controller;

use Codices\Query\AccountFilter;
use Codices\Service\AccountService;
use Codices\View\Facade\AccountForm;
use Yii;
use yii\data\ArrayDataProvider;
use yii\web\Response;

final class AccountController extends CodicesController {

    public function __construct($id, $module, private readonly AccountService $accountService, $config = []) {
        parent::__construct($id, $module, $config);
    }

    public function index(): Response|string {
        $queryParams = Yii::$app->request->get();
        $filter = AccountFilter::fromArray($queryParams);
        $result = $this->accountService->search($filter);

        $dataProvider = new ArrayDataProvider([
            'allModels' => $result->items,
            'totalCount' => $result->total,
            'pagination' => [
                'pageSize' => $result->pageSize,
                'page' => $result->page - 1, // zero-based
                'pageParam' => 'page',
                'pageSizeParam' => 'per_page',
            ],
            'sort' => [
                'attributes' => [
                    'id' => [
                        'asc' => ['id' => SORT_ASC],
                        'desc' => ['id' => SORT_DESC],
                        'label' => 'ID',
                    ],
                    'username' => [
                        'asc' => ['username' => SORT_ASC],
                        'desc' => ['username' => SORT_DESC],
                        'default' => SORT_ASC,
                        'label' => 'Username',
                    ],
                    'email' => [
                        'asc' => ['email' => SORT_ASC],
                        'desc' => ['email' => SORT_DESC],
                        'label' => 'Email',
                    ],
                    'name' => [
                        'asc' => ['name' => SORT_ASC],
                        'desc' => ['name' => SORT_DESC],
                        'label' => 'Name',
                    ],
                ],
                'defaultOrder' => [
                    $filter->sort => $filter->direction === 'desc' ? SORT_DESC : SORT_ASC,
                ],
                'sortParam' => 'sort',
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'filter' => $filter,
            'queryParams' => $queryParams,
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
        $form = new AccountForm();
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

        $form = new AccountForm();
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
            'accountId' => $id,
            'csrf' => Yii::$app->request->getCsrfToken(),
        ]);
    }

    public function delete(): Response|string {
        $id = (int)Yii::$app->request->get('id');
        $this->accountService->delete($id);
        return $this->redirect(['/account/index']);
    }
}
