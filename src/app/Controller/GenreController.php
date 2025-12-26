<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Controller;

use Codices\Service\GenreService;
use Codices\View\Facade\GenreForm;
use Codices\View\Model\GenreSearch;
use Yii;
use yii\web\Response;

final class GenreController extends CodicesController {

    public function __construct($id, $module, private readonly GenreService $genreService, $config = []) {
        parent::__construct($id, $module, $config);
    }

    public function index(): Response|string {
        $searchModel = new GenreSearch();
        $dataProvider = $searchModel->search($this->genreService, Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function view(): Response|string {
        $id = (int)Yii::$app->request->get('id');
        $genre = $this->genreService->findById($id);
        if ($genre === null) {
            return $this->asJson(['message' => 'Not found'])->setStatusCode(404);
        }

        return $this->render('view', [
            'genre' => $genre,
        ]);
    }

    public function add(): Response|string {
        $form = new GenreForm();
        $request = Yii::$app->request;
        if ($request->isPost) {
            $form->setAttributes($request->post());
            if ($form->validate()) {
                $ownerId = 1; // TODO: replace with current user id
                $this->genreService->create($form, $ownerId);
                return $this->redirect(['/genre/index']);
            }
        }

        return $this->render('add', [
            'model' => $form,
            'csrf' => Yii::$app->request->getCsrfToken(),
        ]);
    }

    public function edit(): Response|string {
        $id = (int)Yii::$app->request->get('id');
        $genre = $this->genreService->findById($id);
        if ($genre === null) {
            return $this->asJson(['message' => 'Not found'])->setStatusCode(404);
        }

        $form = new GenreForm();
        $form->loadFromGenre($genre);

        $request = Yii::$app->request;
        if ($request->isPost) {
            $form->setAttributes($request->post());
            if ($form->validate()) {
                $this->genreService->update($id, $form);
                return $this->redirect(['/genre/index']);
            }
        }

        return $this->render('edit', [
            'model' => $form,
            'genreId' => $id,
            'csrf' => Yii::$app->request->getCsrfToken(),
        ]);
    }

    public function delete(): Response|string {
        $id = (int)Yii::$app->request->get('id');
        $this->genreService->delete($id);
        return $this->redirect(['/genre/index']);
    }
}
