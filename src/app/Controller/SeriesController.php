<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Controller;

use Codices\Service\SeriesService;
use Codices\View\Facade\SeriesForm;
use Yii;
use yii\web\Response;

final class SeriesController extends CodicesController {

    public function __construct($id, $module, private readonly SeriesService $seriesService, $config = []) {
        parent::__construct($id, $module, $config);
    }

    public function index(): Response|string {
        $request = Yii::$app->request;
        $page = (int)$request->get('page', 1);
        $pageSize = (int)$request->get('per_page', 10);
        $sort = (string)$request->get('sort', 'name');
        $direction = (string)$request->get('sort_dir', 'asc');

        $paginator = $this->seriesService->list($page, $pageSize, $sort, $direction);

        return $this->render('index', [
            'paginator' => $paginator,
        ]);
    }

    public function view(): Response|string {
        $id = (int)Yii::$app->request->get('id');
        $series = $this->seriesService->findById($id);
        if ($series === null) {
            return $this->asJson(['message' => 'Not found'])->setStatusCode(404);
        }

        return $this->render('view', [
            'series' => $series,
        ]);
    }

    public function add(): Response|string {
        $form = new SeriesForm();
        $request = Yii::$app->request;
        if ($request->isPost) {
            $form->setAttributes($request->post());
            if ($form->validate()) {
                $ownerId = 1; // TODO: replace with current user id
                $this->seriesService->create($form, $ownerId);
                return $this->redirect(['/series/index']);
            }
        }

        return $this->render('add', [
            'model' => $form,
            'csrf' => Yii::$app->request->getCsrfToken(),
        ]);
    }

    public function edit(): Response|string {
        $id = (int)Yii::$app->request->get('id');
        $series = $this->seriesService->findById($id);
        if ($series === null) {
            return $this->asJson(['message' => 'Not found'])->setStatusCode(404);
        }

        $form = new SeriesForm();
        $form->loadFromSeries($series);

        $request = Yii::$app->request;
        if ($request->isPost) {
            $form->setAttributes($request->post());
            if ($form->validate()) {
                $this->seriesService->update($id, $form);
                return $this->redirect(['/series/index']);
            }
        }

        return $this->render('edit', [
            'model' => $form,
            'seriesId' => $id,
            'csrf' => Yii::$app->request->getCsrfToken(),
        ]);
    }

    public function delete(): Response|string {
        $id = (int)Yii::$app->request->get('id');
        $this->seriesService->delete($id);
        return $this->redirect(['/series/index']);
    }
}
