<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Genre;
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
final class GenreController {

    private ServerRequestInterface $request;
    private ResponseInterface $response;

    public function __construct(private ViewRenderer $viewRenderer, ServerRequestInterface $request,
                                ResponseInterface    $response) {

        $this->viewRenderer = $viewRenderer->withControllerName('genre');
        $this->request = $request;
        $this->response = $response;
    }

    public function index(CurrentRoute $currentRoute): ResponseInterface {
        $query = Genre::find()->orderBy(['name' => Sort::SORT_ASC]);
        $paginator = (new OffsetPaginator($query))
            ->withPageSize(10)
            ->withCurrentPage((int)$currentRoute->getArgument('page', '1'));

        return $this->viewRenderer->render('index', [
            'paginator' => $paginator,
        ]);
    }

    public function view(CurrentRoute $currentRoute): ResponseInterface {
        $id = $currentRoute->getArgument('id');
        $genre = Genre::findOne(['id' => $id]);

        if ($genre === null) {
            return $this->viewRenderer->renderWithStatus('_404', [], 404);
        }

        return $this->viewRenderer->render('view', [
            'genre' => $genre,
        ]);
    }

    public function create(ValidatorInterface $validator): ResponseInterface {
        $genre = new Genre();
        $method = $this->request->getMethod();
        $errors = [];

        if ($method === Method::POST) {
            $body = $this->request->getParsedBody();
            $genre->setAttributes($body);

            // Set the owner ID to the current user
            $genre->ownedById = 1; // This should be replaced with the current user ID

            $errors = $validator->validate($genre);
            if (empty($errors)) {
                if ($genre->save()) {
                    return $this->response->withStatus(302)->withHeader('Location', '/genre/view/' . $genre->id);
                }
            }
        }

        return $this->viewRenderer->render('create', [
            'genre' => $genre,
            'errors' => $errors,
        ]);
    }

    public function update(CurrentRoute $currentRoute, ValidatorInterface $validator): ResponseInterface {
        $id = $currentRoute->getArgument('id');
        $genre = Genre::findOne(['id' => $id]);

        if ($genre === null) {
            return $this->viewRenderer->renderWithStatus('_404', [], 404);
        }

        $method = $this->request->getMethod();
        $errors = [];

        if ($method === Method::POST) {
            $body = $this->request->getParsedBody();
            $genre->setAttributes($body);

            $errors = $validator->validate($genre);
            if (empty($errors)) {
                if ($genre->save()) {
                    return $this->response->withStatus(302)->withHeader('Location', '/genre/view/' . $genre->id);
                }
            }
        }

        return $this->viewRenderer->render('update', [
            'genre' => $genre,
            'errors' => $errors,
        ]);
    }

    public function delete(CurrentRoute $currentRoute): ResponseInterface {
        $id = $currentRoute->getArgument('id');
        $genre = Genre::findOne(['id' => $id]);

        if ($genre !== null) {
            $genre->delete();
        }

        return $this->response->withStatus(302)->withHeader('Location', '/genre');
    }
}
