<?php

declare(strict_types=1);

namespace Codices\Controller;

use Codices\Model\Account;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Yiisoft\Http\Method;
use Yiisoft\Yii\View\Renderer\ViewRenderer;
use Yiisoft\Session\SessionInterface;

//use Yiisoft\User\CurrentUser;

final class AppController {

    public function __construct(private ViewRenderer      $viewRenderer, private ServerRequestInterface $request,
                                private ResponseInterface $response) {

        $this->viewRenderer = $viewRenderer->withControllerName('site');
    }

    public function index(): ResponseInterface {
        return $this->viewRenderer->render('index');
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
}
