<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Collection;
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
final class CollectionController {

    private ServerRequestInterface $request;
    private ResponseInterface $response;

    public function __construct(private ViewRenderer $viewRenderer, ServerRequestInterface $request,
                                ResponseInterface    $response) {

        $this->viewRenderer = $viewRenderer->withControllerName('collection');
        $this->request = $request;
        $this->response = $response;
    }

    public function index(CurrentRoute $currentRoute): ResponseInterface {
        $query = Collection::find()->orderBy(['name' => Sort::SORT_ASC]);
        $paginator = (new OffsetPaginator($query))
            ->withPageSize(10)
            ->withCurrentPage((int)$currentRoute->getArgument('page', '1'));

        return $this->viewRenderer->render('index', [
            'paginator' => $paginator,
        ]);
    }

    public function view(CurrentRoute $currentRoute): ResponseInterface {
        $id = $currentRoute->getArgument('id');
        $collection = Collection::findOne(['id' => $id]);

        if ($collection === null) {
            return $this->viewRenderer->renderWithStatus('_404', [], 404);
        }

        return $this->viewRenderer->render('view', [
            'collection' => $collection,
        ]);
    }

    public function create(ValidatorInterface $validator): ResponseInterface {
        $collection = new Collection();
        $method = $this->request->getMethod();
        $errors = [];

        if ($method === Method::POST) {
            $body = $this->request->getParsedBody();
            $collection->setAttributes($body);

            // Set the owner ID to the current user
            $collection->ownedById = 1; // This should be replaced with the current user ID

            $errors = $validator->validate($collection);
            if (empty($errors)) {
                if ($collection->save()) {
                    return $this->response->withStatus(302)->withHeader('Location', '/collection/view/' . $collection->id);
                }
            }
        }

        return $this->viewRenderer->render('create', [
            'collection' => $collection,
            'errors' => $errors,
        ]);
    }

    public function update(CurrentRoute $currentRoute, ValidatorInterface $validator): ResponseInterface {
        $id = $currentRoute->getArgument('id');
        $collection = Collection::findOne(['id' => $id]);

        if ($collection === null) {
            return $this->viewRenderer->renderWithStatus('_404', [], 404);
        }

        $method = $this->request->getMethod();
        $errors = [];

        if ($method === Method::POST) {
            $body = $this->request->getParsedBody();
            $collection->setAttributes($body);

            $errors = $validator->validate($collection);
            if (empty($errors)) {
                if ($collection->save()) {
                    return $this->response->withStatus(302)->withHeader('Location', '/collection/view/' . $collection->id);
                }
            }
        }

        return $this->viewRenderer->render('update', [
            'collection' => $collection,
            'errors' => $errors,
        ]);
    }

    public function delete(CurrentRoute $currentRoute): ResponseInterface {
        $id = $currentRoute->getArgument('id');
        $collection = Collection::findOne(['id' => $id]);

        if ($collection !== null) {
            $collection->delete();
        }

        return $this->response->withStatus(302)->withHeader('Location', '/collection');
    }
}
