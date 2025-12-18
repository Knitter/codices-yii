<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Controller;

use Codices\View\Facade\LoginForm;
use Yii;
use yii\web\Response;

final class AppController extends CodicesController {

    public function index(): string {
        return $this->render('index');
    }

    public function login(): Response|string {
        $request = Yii::$app->request;
        $user = Yii::$app->user;

        if (!$user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load($request->post()) && $model->login()) {
            return $this->goBack('/');
        }

        return $this->render('//app/login', [
            'model' => $model,
            'csrf' => $request->getCsrfToken(),
        ]);
    }

    public function logout(): Response {
        Yii::$app->user->logout();
        return $this->redirect(['/app/index']);
    }
}
