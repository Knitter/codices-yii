<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Controller;

use Codices\Service\CollectionService;
use Codices\View\Facade\CollectionForm;
use Codices\View\Model\CollectionSearch;
use Yii;
use yii\web\Response;

final class CollectionController extends CodicesController {

    public function __construct($id, $module, private readonly CollectionService $collectionService, $config = []) {
        parent::__construct($id, $module, $config);
    }

    public function index(): Response|string {
        $searchModel = new CollectionSearch();
        $dataProvider = $searchModel->search($this->collectionService, Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function view(): Response|string {
        $id = (int)Yii::$app->request->get('id');
        $collection = $this->collectionService->findById($id);
        if ($collection === null) {
            return $this->asJson(['message' => 'Not found'])->setStatusCode(404);
        }

        return $this->render('view', [
            'collection' => $collection,
        ]);
    }

    public function add(): Response|string {
        $form = new CollectionForm();
        $request = Yii::$app->request;
        if ($request->isPost) {
            $form->setAttributes($request->post());
            if ($form->validate()) {
                $ownerId = 1; // TODO: replace with current user id
                $this->collectionService->create($form, $ownerId);
                return $this->redirect(['/collection/index']);
            }
        }

        return $this->render('add', [
            'model' => $form,
            'csrf' => Yii::$app->request->getCsrfToken(),
        ]);
    }

    public function edit(): Response|string {
        $id = (int)Yii::$app->request->get('id');
        $collection = $this->collectionService->findById($id);
        if ($collection === null) {
            return $this->asJson(['message' => 'Not found'])->setStatusCode(404);
        }

        $form = new CollectionForm();
        $form->loadFromCollection($collection);

        $request = Yii::$app->request;
        if ($request->isPost) {
            $form->setAttributes($request->post());
            if ($form->validate()) {
                $this->collectionService->update($id, $form);
                return $this->redirect(['/collection/index']);
            }
        }

        return $this->render('edit', [
            'model' => $form,
            'collectionId' => $id,
            'csrf' => Yii::$app->request->getCsrfToken(),
        ]);
    }

    public function delete(): Response|string {
        $id = (int)Yii::$app->request->get('id');
        $this->collectionService->delete($id);
        return $this->redirect(['/collection/index']);
    }
}
