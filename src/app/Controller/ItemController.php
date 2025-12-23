<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Controller;

use Codices\Model\Item;
use Codices\Query\ItemFilter;
use Codices\Service\ItemService;
use Codices\Service\ImportService;
use Codices\View\Facade\ImportUploadForm;
use Codices\View\Facade\ImportSelectionForm;
use Yii;
use yii\web\Response;
use yii\web\UploadedFile;

final class ItemController extends CodicesController {

    public function __construct($id, $module, private readonly ItemService $itemService,
                                private readonly ImportService $importService, $config = []
    ) {
        parent::__construct($id, $module, $config);
    }

    public function index(): Response|string {
        return $this->renderBooksByType(null);
    }

    public function books(): Response|string {
        return $this->renderBooksByType(Item::TYPE_PAPER);
    }

    public function ebooks(): Response|string {
        return $this->renderBooksByType(Item::TYPE_EBOOK);
    }

    public function audiobooks(): Response|string {
        return $this->renderBooksByType(Item::TYPE_AUDIO);
    }

    public function view(): Response|string {
        $id = (int)Yii::$app->request->get('id');
        $item = Item::findOne(['id' => $id]);
        if ($item === null) {
            return $this->asJson(['message' => 'Not found'])->setStatusCode(404);
        }
        // Reuse book edit page as details/editor
        return $this->redirect(['/book/edit', 'id' => $id]);
    }

    public function add(): Response|string {
        // Delegate to BookController which contains the full BookForm flow
        return $this->redirect(['/book/add']);
    }

    public function edit(): Response|string {
        $id = (int)Yii::$app->request->get('id');
        return $this->redirect(['/book/edit', 'id' => $id]);
    }

    public function delete(): Response|string {
        $id = (int)Yii::$app->request->get('id');
        $this->itemService->delete($id);
        return $this->redirect(['/book/index']);
    }

    public function import(): Response|string {
        $request = Yii::$app->request;
        $session = Yii::$app->session;

        if ($request->isGet) {
            $form = new ImportUploadForm();
            return $this->render('//item/import_upload', [
                'model' => $form,
                'csrf' => $request->getCsrfToken(),
            ]);
        }

        if ($request->isPost) {
            $stage = (string)$request->post('stage', 'upload');
            if ($stage === 'upload') {
                $form = new ImportUploadForm();
                $form->format = (string)$request->post('format', ImportUploadForm::FORMAT_GENERIC_CSV);
                $form->file = UploadedFile::getInstanceByName('file');
                if ($form->validate()) {
                    // Save uploaded file
                    $uploads = Yii::getAlias('@root/runtime/uploads');
                    if (!is_dir($uploads)) {
                        @mkdir($uploads, 0777, true);
                    }
                    $target = $uploads . DIRECTORY_SEPARATOR . uniqid('import_', true) . '.' . $form->file->extension;
                    $form->file->saveAs($target, false);

                    // Build preview based on selected format
                    switch ($form->format) {
                        case ImportUploadForm::FORMAT_GENERIC_CSV:
                            $preview = $this->importService->buildPreviewFromGenericCsv($target);
                            break;
                        case ImportUploadForm::FORMAT_CALIBRE_CSV:
                            $preview = $this->importService->buildPreviewFromCalibreCsv($target);
                            break;
                        case ImportUploadForm::FORMAT_CODICES_JSON:
                            $preview = $this->importService->buildPreviewFromCodicesJson($target);
                            break;
                        default:
                            throw new \RuntimeException('Unsupported format');
                    }
                    $session->set('import/' . $preview->id, $preview->toArray());

                    return $this->render('//item/import_review', [
                        'preview' => $preview,
                        'csrf' => $request->getCsrfToken(),
                    ]);
                }

                return $this->render('//item/import_upload', [
                    'model' => $form,
                    'csrf' => $request->getCsrfToken(),
                ]);
            }

            if ($stage === 'process') {
                $sel = new ImportSelectionForm();
                $sel->importId = (string)$request->post('importId', '');
                $sel->selected = array_map('intval', (array)$request->post('selected', []));
                if ($sel->validate()) {
                    $data = $session->get('import/' . $sel->importId);
                    if ($data === null) {
                        return $this->asJson(['message' => 'Import session expired'])->setStatusCode(400);
                    }
                    $preview = \Codices\Import\ImportPreview::fromArray($data);
                    $ownerId = 1; // TODO: replace with authenticated user id
                    $result = $this->importService->importFromPreview($preview, $sel->selected, $ownerId);
                    $session->remove('import/' . $sel->importId);
                    Yii::$app->session->setFlash('success', sprintf('Imported %d item(s), skipped %d.', $result->imported, $result->skipped));
                    if ($result->errors) {
                        Yii::$app->session->setFlash('warning', 'Some rows failed: ' . implode('; ', $result->errors));
                    }
                    return $this->redirect(['/book/index']);
                }

                // Validation failed; re-render upload
                $form = new ImportUploadForm();
                return $this->render('//item/import_upload', [
                    'model' => $form,
                    'csrf' => $request->getCsrfToken(),
                ]);
            }
        }

        return $this->asJson(['message' => 'Bad request'])->setStatusCode(400);
    }

    private function renderBooksByType(?string $type): Response|string {
        $queryParams = Yii::$app->request->get();
        if ($type !== null) {
            $queryParams['type'] = $type;
        }
        $filter = ItemFilter::fromArray($queryParams);
        $result = $this->itemService->search($filter);

        $sortOrder = $queryParams['sort'] ?? 'title';
        $sortDirection = $queryParams['sort_dir'] ?? 'asc';
        $sort = [
            'title' => [
                'asc' => ['title' => SORT_ASC],
                'desc' => ['title' => SORT_DESC],
            ],
            'publishYear' => [
                'asc' => ['publishYear' => SORT_ASC],
                'desc' => ['publishYear' => SORT_DESC],
            ],
            'rating' => [
                'asc' => ['rating' => SORT_ASC],
                'desc' => ['rating' => SORT_DESC],
            ],
            'addedOn' => [
                'asc' => ['addedOn' => SORT_ASC],
                'desc' => ['addedOn' => SORT_DESC],
            ],
        ];

        $paginator = [
            'items' => $result->items,
            'total' => $result->total,
            'page' => $result->page,
            'pageSize' => $result->pageSize,
        ];

        // Reuse the existing Book index view, which already renders listings/filters
        return $this->render('book/index', [
            'paginator' => $paginator,
            'queryParams' => $queryParams,
            'sort' => $sort,
            'currentSort' => $sortOrder,
            'currentDirection' => $sortDirection,
        ]);
    }
}
