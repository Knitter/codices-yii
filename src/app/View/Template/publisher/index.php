<?php

declare(strict_types=1);

/**
 * @var \yii\web\View $this
 * @var \yii\data\ArrayDataProvider $dataProvider
 * @var \Codices\Query\PublisherFilter $filter
 * @var array $queryParams
 */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = Yii::t('codices', 'Publishers');
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h2 mb-0">
        <i class="bi bi-building me-2"></i>
        <?= Html::encode($this->title) ?>
    </h1>
    <a class="btn btn-primary" href="<?= Url::to(['publisher/add']) ?>">
        <i class="bi bi-plus-circle me-1"></i> <?= Html::encode(Yii::t('codices', 'Add Publisher')) ?>
    </a>
</div>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <?php $form = ActiveForm::begin([
            'method' => 'get',
            'action' => ['publisher/index'],
            'options' => ['class' => 'row g-2 align-items-end'],
        ]); ?>
        <div class="col-md-4">
            <label class="form-label fw-semibold">Name</label>
            <input type="text" name="name" value="<?= Html::encode($filter->name ?? '') ?>" class="form-control"
                   placeholder="e.g., Penguin">
        </div>
        <div class="col-md-2">
            <label class="form-label fw-semibold">Per page</label>
            <select name="per_page" class="form-select">
                <?php foreach ([10, 20, 50, 100] as $ps): ?>
                    <option value="<?= $ps ?>" <?= $filter->pageSize === $ps ? 'selected' : '' ?>><?= $ps ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label fw-semibold">Sort</label>
            <select name="sort" class="form-select">
                <option value="name" <?= $filter->sort === 'name' ? 'selected' : '' ?>>Name</option>
                <option value="id" <?= $filter->sort === 'id' ? 'selected' : '' ?>>ID</option>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label fw-semibold">Direction</label>
            <select name="sort_dir" class="form-select">
                <option value="asc" <?= $filter->direction === 'asc' ? 'selected' : '' ?>>Asc</option>
                <option value="desc" <?= $filter->direction === 'desc' ? 'selected' : '' ?>>Desc</option>
            </select>
        </div>
        <div class="col-md-2 text-end">
            <button type="submit" class="btn btn-outline-secondary">
                <i class="bi bi-search me-1"></i> Search
            </button>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
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
                        $url = Url::to(['publisher/view', 'id' => $model->id]);
                        return Html::a(Html::encode($model->name), $url, ['class' => 'text-decoration-none']);
                    },
                ],
                [
                    'attribute' => 'website',
                    'format' => 'url',
                    'contentOptions' => ['class' => 'px-4'],
                ],
                [
                    'class' => 'yii\\grid\\ActionColumn',
                    'header' => 'Actions',
                    'headerOptions' => ['class' => 'text-end px-4', 'style' => 'width: 160px'],
                    'contentOptions' => ['class' => 'text-end px-4'],
                    'template' => '{edit} {delete}',
                    'buttons' => [
                        'edit' => static function ($url, $model) {
                            $url = Url::to(['publisher/edit', 'id' => $model->id]);
                            return Html::a('<i class="bi bi-pencil"></i>', $url, ['class' => 'btn btn-sm btn-outline-secondary']);
                        },
                        'delete' => static function ($url, $model) {
                            $url = Url::to(['publisher/delete', 'id' => $model->id]);
                            return Html::a('<i class="bi bi-trash"></i>', $url, [
                                'class' => 'btn btn-sm btn-outline-danger ms-1',
                                'data-confirm' => 'Delete this publisher?',
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
