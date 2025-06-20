<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Series;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Yiisoft\Data\Paginator\OffsetPaginator;
use Yiisoft\Data\Reader\Sort;
use Yiisoft\Http\Method;
use Yiisoft\Router\CurrentRoute;
use Yiisoft\Validator\ValidatorInterface;
use Yiisoft\Yii\View\Renderer\ViewRenderer;

final class SeriesController {

    private ServerRequestInterface $request;
    private ResponseInterface $response;

    public function __construct(
        private ViewRenderer   $viewRenderer,
        ServerRequestInterface $request,
        ResponseInterface      $response
    ) {
        $this->viewRenderer = $viewRenderer->withControllerName('series');
        $this->request = $request;
        $this->response = $response;
    }

    public function index(CurrentRoute $currentRoute): ResponseInterface {
        $query = Series::find()->orderBy(['name' => Sort::SORT_ASC]);
        $paginator = (new OffsetPaginator($query))
            ->withPageSize(10)
            ->withCurrentPage((int)$currentRoute->getArgument('page', '1'));

        return $this->viewRenderer->render('index', [
            'paginator' => $paginator,
        ]);
    }

    public function view(CurrentRoute $currentRoute): ResponseInterface {
        $id = $currentRoute->getArgument('id');
        $series = Series::findOne(['id' => $id]);

        if ($series === null) {
            return $this->viewRenderer->renderWithStatus('_404', [], 404);
        }

        return $this->viewRenderer->render('view', [
            'series' => $series,
        ]);
    }

    public function create(ValidatorInterface $validator): ResponseInterface {
        $series = new Series();
        $method = $this->request->getMethod();
        $errors = [];

        if ($method === Method::POST) {
            $body = $this->request->getParsedBody();
            $series->setAttributes($body);

            // Set the owner ID to the current user
            $series->ownedById = 1; // This should be replaced with the current user ID

            $errors = $validator->validate($series);
            if (empty($errors)) {
                if ($series->save()) {
                    return $this->response->withStatus(302)->withHeader('Location', '/series/view/' . $series->id);
                }
            }
        }

        return $this->viewRenderer->render('create', [
            'series' => $series,
            'errors' => $errors,
        ]);
    }

    public function update(CurrentRoute $currentRoute, ValidatorInterface $validator): ResponseInterface {
        $id = $currentRoute->getArgument('id');
        $series = Series::findOne(['id' => $id]);

        if ($series === null) {
            return $this->viewRenderer->renderWithStatus('_404', [], 404);
        }

        $method = $this->request->getMethod();
        $errors = [];

        if ($method === Method::POST) {
            $body = $this->request->getParsedBody();
            $series->setAttributes($body);

            $errors = $validator->validate($series);
            if (empty($errors)) {
                if ($series->save()) {
                    return $this->response->withStatus(302)->withHeader('Location', '/series/view/' . $series->id);
                }
            }
        }

        return $this->viewRenderer->render('update', [
            'series' => $series,
            'errors' => $errors,
        ]);
    }

    public function delete(CurrentRoute $currentRoute): ResponseInterface {
        $id = $currentRoute->getArgument('id');
        $series = Series::findOne(['id' => $id]);

        if ($series !== null) {
            $series->delete();
        }

        return $this->response->withStatus(302)->withHeader('Location', '/series');
    }
}
