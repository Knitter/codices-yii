<?php

declare(strict_types=1);

namespace App\app\Controller;

use App\app\Model\Publisher;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Yiisoft\Data\Paginator\OffsetPaginator;
use Yiisoft\Data\Reader\Sort;
use Yiisoft\Http\Method;
use Yiisoft\Router\CurrentRoute;
use Yiisoft\Validator\ValidatorInterface;
use Yiisoft\Yii\View\Renderer\ViewRenderer;

/**
 * @since 2025.1
 */
final class PublisherController {

    private ServerRequestInterface $request;
    private ResponseInterface $response;

    public function __construct(private ViewRenderer $viewRenderer, ServerRequestInterface $request,
                                ResponseInterface    $response) {

        $this->viewRenderer = $viewRenderer->withControllerName('publisher');
        $this->request = $request;
        $this->response = $response;
    }

    public function index(CurrentRoute $currentRoute): ResponseInterface {
        $query = Publisher::find()->orderBy(['name' => Sort::SORT_ASC]);
        $paginator = (new OffsetPaginator($query))
            ->withPageSize(10)
            ->withCurrentPage((int)$currentRoute->getArgument('page', '1'));

        return $this->viewRenderer->render('index', [
            'paginator' => $paginator,
            'currentRoute' => $currentRoute,
        ]);
    }

    public function view(CurrentRoute $currentRoute): ResponseInterface {
        $id = $currentRoute->getArgument('id');
        $publisher = Publisher::findOne(['id' => $id]);

        if ($publisher === null) {
            return $this->viewRenderer->renderWithStatus('_404', [], 404);
        }

        return $this->viewRenderer->render('view', [
            'publisher' => $publisher,
        ]);
    }

    public function create(ValidatorInterface $validator): ResponseInterface {
        $publisher = new Publisher();
        $method = $this->request->getMethod();
        $errors = [];

        if ($method === Method::POST) {
            $body = $this->request->getParsedBody();
            $publisher->setAttributes($body);

            // Set the owner ID to the current user
            $publisher->ownedById = 1; // This should be replaced with the current user ID

            $errors = $validator->validate($publisher);
            if (empty($errors)) {
                if ($publisher->save()) {
                    return $this->response->withStatus(302)->withHeader('Location', '/publisher/view/' . $publisher->id);
                }
            }
        }

        return $this->viewRenderer->render('create', [
            'publisher' => $publisher,
            'errors' => $errors,
        ]);
    }

    public function update(CurrentRoute $currentRoute, ValidatorInterface $validator): ResponseInterface {
        $id = $currentRoute->getArgument('id');
        $publisher = Publisher::findOne(['id' => $id]);

        if ($publisher === null) {
            return $this->viewRenderer->renderWithStatus('_404', [], 404);
        }

        $method = $this->request->getMethod();
        $errors = [];

        if ($method === Method::POST) {
            $body = $this->request->getParsedBody();
            $publisher->setAttributes($body);

            $errors = $validator->validate($publisher);
            if (empty($errors)) {
                if ($publisher->save()) {
                    return $this->response->withStatus(302)->withHeader('Location', '/publisher/view/' . $publisher->id);
                }
            }
        }

        return $this->viewRenderer->render('update', [
            'publisher' => $publisher,
            'errors' => $errors,
        ]);
    }

    public function delete(CurrentRoute $currentRoute): ResponseInterface {
        $id = $currentRoute->getArgument('id');
        $publisher = Publisher::findOne(['id' => $id]);

        if ($publisher !== null) {
            $publisher->delete();
        }

        return $this->response->withStatus(302)->withHeader('Location', '/publisher');
    }
}
