<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Controller;

use Codices\Service\PublisherService;
use Codices\View\Facade\PublisherForm;
use Codices\View\Model\PublisherSearch;
use Yii;
use yii\web\Response;

final class PublisherController extends CodicesController {

    public function __construct($id, $module, private readonly PublisherService $publisherService, $config = []) {
        parent::__construct($id, $module, $config);
    }

    public function index(): Response|string {
        $searchModel = new PublisherSearch();
        $dataProvider = $searchModel->search($this->publisherService, Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function view(): Response|string {
        $id = (int)Yii::$app->request->get('id');
        $publisher = $this->publisherService->findById($id);
        if ($publisher === null) {
            return $this->asJson(['message' => 'Not found'])->setStatusCode(404);
        }

        return $this->render('view', [
            'publisher' => $publisher,
        ]);
    }

    public function add(): Response|string {
        $form = new PublisherForm();
        $request = Yii::$app->request;
        if ($request->isPost) {
            $form->setAttributes($request->post());
            $ownerId = 1; // TODO: replace with current user id
            $form->ownedById = $ownerId;
            if ($form->validate()) {
                $this->publisherService->create($form, $ownerId);
                return $this->redirect(['/publisher/index']);
            }
        }

        return $this->render('add', [
            'model' => $form,
            'csrf' => Yii::$app->request->getCsrfToken(),
        ]);
    }

    public function edit(): Response|string {
        $id = (int)Yii::$app->request->get('id');
        $publisher = $this->publisherService->findById($id);
        if ($publisher === null) {
            return $this->asJson(['message' => 'Not found'])->setStatusCode(404);
        }

        $form = new PublisherForm();
        $form->loadFromPublisher($publisher);

        $request = Yii::$app->request;
        if ($request->isPost) {
            $form->setAttributes($request->post());
            if ($form->validate()) {
                $this->publisherService->update($id, $form);
                return $this->redirect(['/publisher/index']);
            }
        }

        return $this->render('edit', [
            'model' => $form,
            'publisherId' => $id,
            'csrf' => Yii::$app->request->getCsrfToken(),
        ]);
    }

    public function delete(): Response|string {
        $id = (int)Yii::$app->request->get('id');
        $this->publisherService->delete($id);
        return $this->redirect(['/publisher/index']);
    }
}
