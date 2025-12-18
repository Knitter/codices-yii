<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Controller;

use Codices\Model\Format;
use Codices\Service\FormatService;
use Codices\View\Facade\FormatForm;
use Codices\Query\FormatFilter;
use Yii;
use yii\data\ArrayDataProvider;
use yii\web\Response;

final class FormatController extends CodicesController {

    public function __construct($id, $module, private readonly FormatService $formatService, $config = []) {
        parent::__construct($id, $module, $config);
    }

    public function index(): Response|string {
        $queryParams = Yii::$app->request->get();
        $filter = FormatFilter::fromArray($queryParams);
        $result = $this->formatService->search($filter);

        $dataProvider = new ArrayDataProvider([
            'allModels' => $result->items,
            'totalCount' => $result->total,
            'pagination' => [
                'pageSize' => $result->pageSize,
                'page' => $result->page - 1,
                'pageParam' => 'page',
                'pageSizeParam' => 'per_page',
            ],
            'sort' => [
                'attributes' => [
                    'name' => [
                        'asc' => ['name' => SORT_ASC],
                        'desc' => ['name' => SORT_DESC],
                        'default' => SORT_ASC,
                        'label' => 'Name',
                    ],
                    'type' => [
                        'asc' => ['type' => SORT_ASC],
                        'desc' => ['type' => SORT_DESC],
                        'label' => 'Type',
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
            'formatTypes' => Format::getFormatTypes(),
        ]);
    }

    public function view(): Response|string {
        $type = (string)Yii::$app->request->get('type', '');
        $name = (string)Yii::$app->request->get('name', '');
        $ownerId = 1; // TODO: current user id

        $format = $this->formatService->findOne($type, $name, $ownerId);
        if ($format === null) {
            return $this->asJson(['message' => 'Not found'])->setStatusCode(404);
        }

        return $this->render('view', [
            'format' => $format,
            'formatTypes' => Format::getFormatTypes(),
        ]);
    }

    public function add(): Response|string {
        $form = new FormatForm();
        $request = Yii::$app->request;
        if ($request->isPost) {
            $form->setAttributes($request->post());
            if ($form->validate()) {
                $ownerId = 1; // TODO: replace with current user id
                $this->formatService->create($form, $ownerId);
                return $this->redirect(['/format/index']);
            }
        }

        return $this->render('add', [
            'model' => $form,
            'formatTypes' => Format::getFormatTypes(),
            'csrf' => Yii::$app->request->getCsrfToken(),
        ]);
    }

    public function edit(): Response|string {
        $type = (string)Yii::$app->request->get('type', '');
        $name = (string)Yii::$app->request->get('name', '');
        $ownerId = 1; // TODO: current user id
        $format = $this->formatService->findOne($type, $name, $ownerId);
        if ($format === null) {
            return $this->asJson(['message' => 'Not found'])->setStatusCode(404);
        }

        $form = new FormatForm();
        $form->loadFromFormat($format);

        $request = Yii::$app->request;
        if ($request->isPost) {
            $form->setAttributes($request->post());
            if ($form->validate()) {
                // Use original keys from query to locate the record, allow updating keys via form
                $this->formatService->update($type, $name, $ownerId, $form);
                return $this->redirect(['/format/index']);
            }
        }

        return $this->render('edit', [
            'model' => $form,
            'formatType' => $type,
            'formatName' => $name,
            'formatTypes' => Format::getFormatTypes(),
            'csrf' => Yii::$app->request->getCsrfToken(),
        ]);
    }

    public function delete(): Response|string {
        $type = (string)Yii::$app->request->get('type', '');
        $name = (string)Yii::$app->request->get('name', '');
        $ownerId = 1; // TODO: current user id
        $this->formatService->delete($type, $name, $ownerId);
        return $this->redirect(['/format/index']);
    }
}
