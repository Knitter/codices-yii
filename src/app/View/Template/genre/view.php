<?php

declare(strict_types=1);

/**
 * @var \yii\web\View $this
 * @var \Codices\Model\Genre $genre
 */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Html::encode($genre->name);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2 mb-0">
        <i class="bi bi-tag me-2"></i>
        <?= Html::encode($genre->name) ?>
    </h1>
    <div>
        <a class="btn btn-outline-secondary" href="<?= Url::to(['genre/index']) ?>">
            <i class="bi bi-arrow-left me-1"></i> Back to Genres
        </a>
        <a class="btn btn-primary ms-2" href="<?= Url::to(['genre/edit', 'id' => $genre->id]) ?>">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-2">ID</dt>
            <dd class="col-sm-10"><?= Html::encode((string)$genre->id) ?></dd>

            <dt class="col-sm-2">Name</dt>
            <dd class="col-sm-10"><?= Html::encode($genre->name) ?></dd>
        </dl>
    </div>
</div>
