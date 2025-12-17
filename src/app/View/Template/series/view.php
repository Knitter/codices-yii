<?php

declare(strict_types=1);

/**
 * @var \yii\web\View $this
 * @var \Codices\Model\Series $series
 */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Html::encode($series->name);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2 mb-0">
        <i class="bi bi-collection me-2"></i>
        <?= Html::encode($series->name) ?>
    </h1>
    <div>
        <a class="btn btn-outline-secondary" href="<?= Url::to(['series/index']) ?>">
            <i class="bi bi-arrow-left me-1"></i> Back to Series
        </a>
        <a class="btn btn-primary ms-2" href="<?= Url::to(['series/edit', 'id' => $series->id]) ?>">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-2">ID</dt>
            <dd class="col-sm-10"><?= Html::encode((string)$series->id) ?></dd>

            <dt class="col-sm-2">Name</dt>
            <dd class="col-sm-10"><?= Html::encode($series->name) ?></dd>
        </dl>
    </div>
</div>
