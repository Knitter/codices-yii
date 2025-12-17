<?php

declare(strict_types=1);

/**
 * @var \yii\web\View $this
 * @var \Codices\Model\Author $author
 */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Html::encode($author->name);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2 mb-0">
        <i class="bi bi-person-fill me-2"></i>
        <?= Html::encode($author->name) ?>
    </h1>
    <div>
        <a class="btn btn-outline-secondary" href="<?= Url::to(['author/index']) ?>">
            <i class="bi bi-arrow-left me-1"></i> Back to Authors
        </a>
        <a class="btn btn-primary ms-2" href="<?= Url::to(['author/edit', 'id' => $author->id]) ?>">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
    </div>
    </div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-2">ID</dt>
            <dd class="col-sm-10"><?= Html::encode((string)$author->id) ?></dd>

            <dt class="col-sm-2">Name</dt>
            <dd class="col-sm-10"><?= Html::encode($author->name) ?></dd>
        </dl>
    </div>
</div>
