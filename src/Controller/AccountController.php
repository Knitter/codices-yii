<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Account;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Yiisoft\Data\Paginator\OffsetPaginator;
use Yiisoft\Data\Reader\Sort;
use Yiisoft\Data\Reader\OrderHelper;
use Yiisoft\Http\Method;
use Yiisoft\Router\CurrentRoute;
use Yiisoft\Validator\ValidatorInterface;
use Yiisoft\Yii\View\Renderer\ViewRenderer;
use Yiisoft\Session\SessionInterface;
use Yiisoft\User\CurrentUser;

/**
 * @since 2025.1
 */
final class AccountController {

    private ServerRequestInterface $request;
    private ResponseInterface $response;

    public function __construct(
        private ViewRenderer   $viewRenderer,
        ServerRequestInterface $request,
        ResponseInterface      $response
    ) {
        $this->viewRenderer = $viewRenderer->withControllerName('account');
        $this->request = $request;
        $this->response = $response;
    }

    public function index(CurrentRoute $currentRoute): ResponseInterface {
        $query = Account::find()->orderBy(['username' => SORT_ASC]);
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
        $account = Account::findOne(['id' => $id]);

        if ($account === null) {
            return $this->viewRenderer->renderWithStatus('_404', [], 404);
        }

        return $this->viewRenderer->render('view', [
            'account' => $account,
        ]);
    }

    public function create(ValidatorInterface $validator): ResponseInterface {
        $account = new Account();
        $method = $this->request->getMethod();
        $errors = [];

        if ($method === Method::POST) {
            $body = $this->request->getParsedBody();
            $account->setAttributes($body);

            $errors = $validator->validate($account);
            if (empty($errors)) {
                $account->generateAuthKey();
                if ($account->save()) {
                    return $this->response->withStatus(302)->withHeader('Location', '/account/view/' . $account->id);
                }
            }
        }

        return $this->viewRenderer->render('create', [
            'account' => $account,
            'errors' => $errors,
        ]);
    }

    public function update(CurrentRoute $currentRoute, ValidatorInterface $validator): ResponseInterface {
        $id = $currentRoute->getArgument('id');
        $account = Account::findOne(['id' => $id]);

        if ($account === null) {
            return $this->viewRenderer->renderWithStatus('_404', [], 404);
        }

        $method = $this->request->getMethod();
        $errors = [];

        if ($method === Method::POST) {
            $body = $this->request->getParsedBody();
            $account->setAttributes($body);

            $errors = $validator->validate($account);
            if (empty($errors)) {
                if ($account->save()) {
                    return $this->response->withStatus(302)->withHeader('Location', '/account/view/' . $account->id);
                }
            }
        }

        return $this->viewRenderer->render('update', [
            'account' => $account,
            'errors' => $errors,
        ]);
    }

    public function delete(CurrentRoute $currentRoute): ResponseInterface {
        $id = $currentRoute->getArgument('id');
        $account = Account::findOne(['id' => $id]);

        if ($account !== null) {
            $account->delete();
        }

        return $this->response->withStatus(302)->withHeader('Location', '/account');
    }

    public function login(): ResponseInterface {
        $this->viewRenderer = $this->viewRenderer->withLayout('@layout/auth');
        $method = $this->request->getMethod();
        $errors = [];
        $username = '';

        if ($method === Method::POST) {
            $body = $this->request->getParsedBody();
            $username = $body['username'] ?? '';
            $password = $body['password'] ?? '';

            if (empty($username) || empty($password)) {
                $errors[] = 'Username and password are required.';
            } else {
                // Find user by username
                $account = Account::findOne(['username' => $username]);

                if ($account && $account->validatePassword($password)) {
                    // Login successful - redirect to dashboard
                    return $this->response->withStatus(302)->withHeader('Location', '/');
                } else {
                    $errors[] = 'Invalid username or password.';
                }
            }
        }

        return $this->viewRenderer->render('login', [
            'errors' => $errors,
            'username' => $username,
        ]);
    }

    public function profile(): ResponseInterface {
        // Get current user account
        $account = Account::findOne(['id' => $this->user->getId()]);

        return $this->viewRenderer->render('profile', [
            'account' => $account,
        ]);
    }
}
