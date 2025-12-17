<?php

declare(strict_types=1);

/**
 * @var \yii\web\View $this
 * @var \Codices\View\Facade\FormatForm $model
 * @var array $formatTypes
 * @var string $csrf
 */

use yii\helpers\Html;
use yii\helpers\Url;

if (!isset($csrf)) {
    $csrf = Yii::$app->request->getCsrfToken();
}

$this->title = Yii::t('codices', 'Add Format');
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2 mb-0">
        <i class="bi bi-file-earmark-plus me-2"></i>
        <?= Html::encode($this->title) ?>
    </h1>
    <a href="<?= Url::to(['format/index']) ?>" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Formats
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="post" class="needs-validation" novalidate>
            <input type="hidden" name="_csrf" value="<?= $csrf ?>">

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="type" class="form-label fw-semibold">Type <span class="text-danger">*</span></label>
                    <select class="form-select" id="type" name="type" required>
                        <option value="">Choose type...</option>
                        <?php foreach ($formatTypes as $key => $label): ?>
                            <option value="<?= Html::encode($key) ?>" <?= ($model->type ?? '') === $key ? 'selected' : '' ?>>
                                <?= Html::encode($label) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if ($model->hasErrors('type')): ?>
                        <div class="text-danger small mt-1">
                            <?= Html::encode(implode(' ', $model->getErrors('type'))) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-8 mb-3">
                    <label for="name" class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" required
                           value="<?= Html::encode($model->name ?? '') ?>" placeholder="e.g., Hardcover, EPUB, MP3">
                    <?php if ($model->hasErrors('name')): ?>
                        <div class="text-danger small mt-1">
                            <?= Html::encode(implode(' ', $model->getErrors('name'))) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="<?= Url::to(['format/index']) ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle me-1"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i> Save Format
                </button>
            </div>
        </form>
    </div>
    </div>
