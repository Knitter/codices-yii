<?php

declare(strict_types=1);

/**
 * @var \yii\web\View $this
 * @var \yii\data\ArrayDataProvider $dataProvider
 * @var \Codices\View\Model\GenreSearch $searchModel
 */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('codices', 'Genres');

?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2 mb-0">
        <i class="bi bi-tags me-2"></i>
        <?= Html::encode($this->title) ?>
    </h1>
    <a class="btn btn-primary" href="<?= Url::to(['genre/add']) ?>">
        <i class="bi bi-plus-circle me-1"></i> Add Genre
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'table table-hover align-middle mb-0'],
            'layout' => "{items}\n<div class=\"p-3\">{pager}</div>",
            'columns' => [
                [
                    'attribute' => 'id',
                    'contentOptions' => ['class' => 'px-4 text-muted', 'style' => 'width: 100px'],
                ],
                [
                    'attribute' => 'name',
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'px-4'],
                    'value' => static function ($model) {
                        $url = Url::to(['genre/view', 'id' => $model->id]);
                        return Html::a(Html::encode($model->name), $url, ['class' => 'text-decoration-none']);
                    },
                ],
                [
                    'class' => 'yii\\grid\\ActionColumn',
                    'header' => 'Actions',
                    'headerOptions' => ['class' => 'text-end px-4', 'style' => 'width: 160px'],
                    'contentOptions' => ['class' => 'text-end px-4'],
                    'template' => '{edit} {delete}',
                    'buttons' => [
                        'edit' => static function ($url, $model) {
                            $url = Url::to(['genre/edit', 'id' => $model->id]);
                            return Html::a('<i class="bi bi-pencil"></i>', $url, ['class' => 'btn btn-sm btn-outline-secondary']);
                        },
                        'delete' => static function ($url, $model) {
                            $url = Url::to(['genre/delete', 'id' => $model->id]);
                            return Html::a('<i class="bi bi-trash"></i>', $url, [
                                'class' => 'btn btn-sm btn-outline-danger ms-1',
                                'data-confirm' => 'Delete this genre?',
                            ]);
                        },
                    ],
                ],
            ],
            'pager' => [
                'options' => ['class' => 'pagination mb-0'],
            ],
        ]); ?>
    </div>
</div>
