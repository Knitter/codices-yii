<?php

namespace App\Controller;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
final class BookController extends Controller {

    //TODO: Access control ...
    ///**
    // * {@inheritdoc}
    // */
    //public function behaviors() {
    //    return [
    //        'access' => [
    //            'class' => AccessControl::class,
    //            'rules' => [
    //                ['actions' => ['', ''], 'allow' => true],
    //                ['actions' => ['', ''], 'allow' => true, 'roles' => ['@']],
    //            ],
    //        ],
    //    ];
    //}

    /**
     * @return string
     */
    public function actionIndex(): string {
        return $this->render('index');
    }

    public function actionAdd() {

    }

    public function actionEdit() {

    }

    public function actionRemove() {

    }
}
