<?php

namespace App\Controller;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\Response;

final class AppController extends Controller {

    public function behaviors(): array {
        return [
            //'access' => [
            //    'class' => AccessControl::class,
            //    'rules' => [
            //        ['actions' => ['login', 'error'], 'allow' => true],
            //        ['actions' => ['logout', 'index'], 'allow' => true, 'roles' => ['@']],
            //    ],
            //],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ]
            ]
        ];
    }

    public function actions(): array {
        return [
            'error' => [
                'class' => ErrorAction::class
            ],
        ];
    }

    public function actionIndex(): string {
        return 'KO!';
    }

    public function actionLogin(): Response|string {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'login';
        return $this->render('login');
    }

    public function actionLogout(): Response {
        //TODO: Improve logout code and add cleanup process
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
