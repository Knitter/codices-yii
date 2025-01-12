<?php

/*
 * AuthorsController.php
 *
 * Small book management software.
 * Copyright (C) 2016 - 2022 Sérgio Lopes (knitter.is@gmail.com)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * (c) 2016 - 2022 Sérgio Lopes
 */

namespace App\Controller;

use App\Component\Controller;
use App\Filter\Authors;
use App\Form\Author as Form;
use App\Model\Author;
use codices\components\ApplicationController;
use Yii;
use yii\web\Response;

final class AuthorController extends Controllertroller {

    //    /**
    //     * @return string
    //     */
    //    public function actionIndex(): string {
    //        $filter = new Authors(Yii::$app->user->identity->id);
    //        $provider = $filter->search(Yii::$app->request->queryParams);
    //
    //        return $this->render('index', [
    //            'filter' => $filter,
    //            'provider' => $provider
    //        ]);
    //    }
    //
    //    /**
    //     * @return \yii\web\Response|string
    //     */
    //    public function actionAdd(): Response|string {
    //        $form = new Form(Yii::$app->user->identity->id);
    //
    //        if ($form->load(Yii::$app->request->post())) {
    //            if ($form->save()) {
    //                //TODO: Yii::$app->session->setFlash('success', Yii::t('codices', 'New book created.'));
    //                return $this->redirect(['edit', 'id' => $form->id]);
    //            }
    //        }
    //
    //        return $this->render('add', [
    //            'model' => $form,
    //        ]);
    //    }
    //
    //    /**
    //     * @param int $id
    //     * @return string|\yii\web\Response
    //     * @throws \yii\web\NotFoundHttpException
    //     */
    //    public function actionEdit(int $id): Response|string {
    //        $form = new Form(Yii::$app->user->identity->id, $this->findModel(Author::class, $id));
    //
    //        if ($form->load(Yii::$app->request->post())) {
    //            if ($form->save()) {
    //                //TODO: Yii::$app->session->setFlash('success', Yii::t('codices', 'Book details updated.'));
    //                return $this->redirect(['edit', 'id' => $form->id]);
    //            }
    //        }
    //
    //        return $this->render('edit', [
    //            'model' => $form,
    //        ]);
    //    }
    //
    //    public function actionDetails(int $id) {
    //        throw new \Exception('Not implemented yet!');
    //    }
    //
    //    public function actionDelete(int $id) {
    //        throw new \Exception('Not implemented yet!');
    //    }
    //    private final AuthorService service;
    //
    //    public AuthorController(AuthorService service) {
    //        this.service = service;
    //    }
    //
    //    @RequestMapping("/authors")
    //    public String index(Model model) {
    //        model.addAttribute("authors", service.findAll());
    //        return "authors";
    //    }
    //
    //    //@RequestMapping("/authors/edit/<id>")
    //    public void edit() {
    //
    //    }
    //
    //    //@RequestMapping("/authors/delete/<id>")
    //    public void delete() {
    //
    //    }
    //
    //    @RequestMapping("/authors/create")
    //    public void create() {
    //
    //    }
}
