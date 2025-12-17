<?php

declare(strict_types=1);

/**
 * @var \yii\web\View $this
 * @var \Codices\View\Facade\SeriesForm $model
 * @var int $seriesId
 * @var string $csrf
 */

use yii\helpers\Html;
use yii\helpers\Url;

if (!isset($csrf)) {
    $csrf = Yii::$app->request->getCsrfToken();
}

$this->title = Yii::t('codices', 'Edit Series');
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2 mb-0">
        <i class="bi bi-pencil-square me-2"></i>
        <?= Html::encode($this->title) ?>
    </h1>
    <a href="<?= Url::to(['series/index']) ?>" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Series
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="post" class="needs-validation" novalidate>
            <input type="hidden" name="_csrf" value="<?= $csrf ?>">

            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" required
                       value="<?= Html::encode($model->name ?? '') ?>" placeholder="e.g., The Lord of the Rings">
                <?php if ($model->hasErrors('name')): ?>
                    <div class="text-danger small mt-1">
                        <?= Html::encode(implode(' ', $model->getErrors('name'))) ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="d-flex justify-content-between">
                <a href="<?= Url::to(['series/delete', 'id' => $seriesId]) ?>"
                   class="btn btn-outline-danger"
                   onclick="return confirm('Delete this series?');">
                    <i class="bi bi-trash me-1"></i> Delete
                </a>
                <div class="d-flex gap-2">
                    <a href="<?= Url::to(['series/index']) ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-1"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i> Save Changes
                    </button>
                </div>
            </div>
        </form>
    </div>
    </div>
