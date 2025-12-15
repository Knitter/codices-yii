<?php

declare(strict_types=1);

namespace Codices\Controller;

use yii\web\Response;

final class AppController extends CodicesController {

    public function index(): string {
        return $this->render('index');
    }

    public function login(): Response|string {
//        $this->viewRenderer = $this->viewRenderer->withLayout('@layout/auth');
//        $method = $this->request->getMethod();
//        $errors = [];
//        $username = '';
//
//        if ($method === Method::POST) {
//            $body = $this->request->getParsedBody();
//            $username = $body['username'] ?? '';
//            $password = $body['password'] ?? '';
//
//            if (empty($username) || empty($password)) {
//                $errors[] = 'Username and password are required.';
//            } else {
//                // Find user by username
//                $account = Account::findOne(['username' => $username]);
//
//                if ($account && $account->validatePassword($password)) {
//                    // Login successful - redirect to dashboard
//                    return $this->response->withStatus(302)->withHeader('Location', '/');
//                } else {
//                    $errors[] = 'Invalid username or password.';
//                }
//            }
//        }
//
        return $this->render('login', [
//            'errors' => $errors,
//            'username' => $username,
        ]);
    }
}
