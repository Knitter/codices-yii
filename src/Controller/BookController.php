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
//
    //    //TODO: Access control ...
    //    ///**
    //    // * {@inheritdoc}
    //    // */
    //    //public function behaviors() {
    //    //    return [
    //    //        'access' => [
    //    //            'class' => AccessControl::class,
    //    //            'rules' => [
    //    //                ['actions' => ['', ''], 'allow' => true],
    //    //                ['actions' => ['', ''], 'allow' => true, 'roles' => ['@']],
    //    //            ],
    //    //        ],
    //    //    ];
    //    //}
    //
    //    /**
    //     * @return string
    //     */
    //    public function actionIndex(): string {
    //        return $this->render('index');
    //    }
    //
    //    public function actionAdd() {
    //
    //    }
    //
    //    public function actionEdit() {
    //
    //    }
    //
    //    public function actionRemove() {
    //
    //    }
    //    private final ItemService service;
    //
    //    public BookController(ItemService service) {
    //        this.service = service;
    //    }
    //
    //    @RequestMapping("/books")
    //    public String index(Model model) {
    //        model.addAttribute("books", service.findAllBooks());
    //        return "books";
    //    }
    //
    //    //@RequestMapping("/books/edit/<id>")
    //    public void edit() {
    //
    //    }
    //
    //    //@RequestMapping("/books/delete/<id>")
    //    public void delete() {
    //
    //    }
    //
    //    @RequestMapping("/books/create")
    //    public void create() {
    //
    //    }
    ///**
    //     * @return string
    //     */
    //    public function actionIndex(): string {
    //        $filter = new Books(Yii::$app->user->identity->id);
    //        $provider = $filter->search(Yii::$app->request->queryParams);
    //
    //        //TODO: update account based on logged user
    //        $series = ArrayHelper::map(Series::find()
    //            ->where(['ownedById' => 1])
    //            ->orderBy(['name' => SORT_ASC])
    //            ->asArray()
    //            ->all(), 'id', 'name');
    //
    //        return $this->render('index', [
    //            'filter' => $filter,
    //            'provider' => $provider,
    //            'series' => $series
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
    ////            Yii::$app->session->setFlash('success', Yii::t('codices', 'New book created.'));
    //                return $this->redirect(['edit', 'id' => $form->id]);
    //            }
    //        }
    //
    //        $series = [];
    //        $publishers = [];
    //        $genres = [];
    //
    //        return $this->render('add', [
    //            'model' => $form,
    //            'series' => $series,
    //            'publishers' => $publishers,
    //            'genres' => $genres
    //        ]);
    //    }
    //
    //    /**
    //     * @param int $id
    //     * @return \yii\web\Response|string
    //     */
    //    public function actionEdit(int $id): Response|string {
    //        $form = new Form(Yii::$app->user->identity->id, $this->findBook($id));
    //
    //        if ($form->load(Yii::$app->request->post())) {
    //            if ($form->save()) {
    ////            Yii::$app->session->setFlash('success', Yii::t('codices', 'Book details updated.'));
    //                return $this->redirect(['edit', 'id' => $form->id]);
    //            }
    //        }
    //
    //        $series = [];
    //        $publishers = [];
    //        $genres = [];
    //
    //        return $this->render('edit', [
    //            'model' => $form,
    //            'series' => $series,
    //            'publishers' => $publishers,
    //            'genres' => $genres
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
}
