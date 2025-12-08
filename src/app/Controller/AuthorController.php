<?php

declare(strict_types=1);

namespace App\app\Controller;

use App\app\Model\Author;
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
final class AuthorController {

    private ServerRequestInterface $request;
    private ResponseInterface $response;

    public function __construct(
        private ViewRenderer   $viewRenderer,
        ServerRequestInterface $request,
        ResponseInterface      $response
    ) {
        $this->viewRenderer = $viewRenderer->withControllerName('author');
        $this->request = $request;
        $this->response = $response;
    }

    public function index(CurrentRoute $currentRoute): ResponseInterface {
        $query = Author::find()->orderBy(['name' => Sort::SORT_ASC, 'surname' => Sort::SORT_ASC]);
        $paginator = (new OffsetPaginator($query))
            ->withPageSize(10)
            ->withCurrentPage((int)$currentRoute->getArgument('page', '1'));

        return $this->viewRenderer->render('index', [
            'paginator' => $paginator,
        ]);
    }

    public function view(CurrentRoute $currentRoute): ResponseInterface {
        $id = $currentRoute->getArgument('id');
        $author = Author::findOne(['id' => $id]);

        if ($author === null) {
            return $this->viewRenderer->renderWithStatus('_404', [], 404);
        }

        return $this->viewRenderer->render('view', [
            'author' => $author,
        ]);
    }

    public function create(ValidatorInterface $validator): ResponseInterface {
        $author = new Author();
        $method = $this->request->getMethod();
        $errors = [];

        if ($method === Method::POST) {
            $body = $this->request->getParsedBody();
            $author->setAttributes($body);

            // Set the owner ID to the current user
            $author->ownedById = 1; // This should be replaced with the current user ID

            $errors = $validator->validate($author);
            if (empty($errors)) {
                if ($author->save()) {
                    return $this->response->withStatus(302)->withHeader('Location', '/author/view/' . $author->id);
                }
            }
        }

        return $this->viewRenderer->render('create', [
            'author' => $author,
            'errors' => $errors,
        ]);
    }

    public function update(CurrentRoute $currentRoute, ValidatorInterface $validator): ResponseInterface {
        $id = $currentRoute->getArgument('id');
        $author = Author::findOne(['id' => $id]);

        if ($author === null) {
            return $this->viewRenderer->renderWithStatus('_404', [], 404);
        }

        $method = $this->request->getMethod();
        $errors = [];

        if ($method === Method::POST) {
            $body = $this->request->getParsedBody();
            $author->setAttributes($body);

            $errors = $validator->validate($author);
            if (empty($errors)) {
                if ($author->save()) {
                    return $this->response->withStatus(302)->withHeader('Location', '/author/view/' . $author->id);
                }
            }
        }

        return $this->viewRenderer->render('update', [
            'author' => $author,
            'errors' => $errors,
        ]);
    }

    public function delete(CurrentRoute $currentRoute): ResponseInterface {
        $id = $currentRoute->getArgument('id');
        $author = Author::findOne(['id' => $id]);

        if ($author !== null) {
            $author->delete();
        }

        return $this->response->withStatus(302)->withHeader('Location', '/author');
    }
}
