<?php

declare(strict_types=1);

/**
 * @var \yii\web\View $this
 * @var \Codices\Model\Format $format
 * @var array $formatTypes
 */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Html::encode($format->name);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2 mb-0">
        <i class="bi bi-file-earmark me-2"></i>
        <?= Html::encode($format->name) ?>
    </h1>
    <div>
        <a class="btn btn-outline-secondary" href="<?= Url::to(['format/index']) ?>">
            <i class="bi bi-arrow-left me-1"></i> Back to Formats
        </a>
        <a class="btn btn-primary ms-2" href="<?= Url::to(['format/edit', 'type' => $format->type, 'name' => $format->name]) ?>">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
    </div>
    </div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-2">Type</dt>
            <dd class="col-sm-10"><?= Html::encode($formatTypes[$format->type] ?? $format->type) ?></dd>

            <dt class="col-sm-2">Name</dt>
            <dd class="col-sm-10"><?= Html::encode($format->name) ?></dd>
        </dl>
    </div>
</div>
