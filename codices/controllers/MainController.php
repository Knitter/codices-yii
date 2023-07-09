<?php

namespace codices\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\Response;

/**
 * Site controller
 */
final class MainController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
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

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error' => [
                'class' => ErrorAction::class
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex(): string {
        return $this->render('index');
    }

    /**
     * @return string|Response
     */
    public function actionLogin(): Response|string {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'login';
        return $this->render('login');
    }

    /**
     * @return Response
     */
    public function actionLogout(): Response {
        //TODO: Improve logout code and add cleanup process
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
