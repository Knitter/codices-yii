<?php

namespace App\Component;

abstract class Controller extends \yii\web\Controller {

    //    /**
    //     * {@inheritdoc}
    //     */
    //    public function behaviors(): array {
    //        return [
    //            'access' => [
    //                'class' => AccessControl::class,
    //                'rules' => [
    //                    ['allow' => true, 'actions' => ['login']],
    //                    ['allow' => true, 'actions' => ['logout'], 'roles' => ['@']],
    //                    ['allow' => true, 'roles' => ['@']],
    //                    ['allow' => false]
    //                ]
    //            ]
    //        ];
    //    }
    //
    //    /**
    //     * @param string         $class
    //     * @param integer|string $id
    //     * @return \yii\db\ActiveRecord
    //     * @throws \yii\web\NotFoundHttpException
    //     */
    //    protected function findModel(string $class, int|string $id): ActiveRecord {
    //        if (($model = $this->loadModel($class, $id)) !== null) {
    //            return $model;
    //        }
    //
    //        throw new NotFoundHttpException();
    //    }
    //
    //    /**
    //     * @param string         $class
    //     * @param integer|string $id
    //     * @return \yii\db\ActiveRecord|null
    //     */
    //    protected function loadModel(string $class, int|string $id): ?ActiveRecord {
    //        if (($model = $class::findOne($id)) !== null) {
    //            return $model;
    //        }
    //
    //        return null;
    //    }
}
