<?php

declare(strict_types=1);

/**
 * @var \yii\web\View $this
 * @var \Codices\Import\ImportPreview $preview
 * @var string $csrf
 */

use yii\helpers\Html;
use yii\helpers\Url;

if (!isset($csrf)) {
    $csrf = Yii::$app->request->getCsrfToken();
}

$this->title = Yii::t('codices', 'Import Preview');
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2 mb-0">
        <i class="bi bi-eye me-2"></i>
        <?= Html::encode($this->title) ?>
    </h1>
    <a href="<?= Url::to(['item/import']) ?>" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Upload
    </a>
</div>

<div class="alert alert-info">
    Found <?= (int)$preview->total ?> row(s). Duplicate ISBN flags: <?= (int)$preview->duplicates ?>.
</div>

<form method="post" class="card border-0 shadow-sm">
    <input type="hidden" name="_csrf" value="<?= Html::encode($csrf) ?>">
    <input type="hidden" name="stage" value="process">
    <input type="hidden" name="importId" value="<?= Html::encode($preview->id) ?>">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
            <tr>
                <th style="width: 60px;" class="px-3">
                    <input type="checkbox" id="selectAll" checked>
                </th>
                <th>Title</th>
                <th>Authors</th>
                <th>Series</th>
                <th>Genres</th>
                <th>Publisher</th>
                <th>Year</th>
                <th>ISBN</th>
                <th>Language</th>
                <th>Type</th>
                <th>Format</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($preview->rows as $row): ?>
                <?php /** @var \Codices\Import\ImportPreviewRow $row */ ?>
                <?php $warn = ($row->duplicateIsbn || $row->existsInDb) ? 'table-warning' : ''; ?>
                <tr class="<?= $warn ?>">
                    <td class="px-3">
                        <input type="checkbox" name="selected[]" value="<?= (int)$row->index ?>" class="row-check" checked>
                    </td>
                    <td>
                        <div class="fw-semibold"><?= Html::encode($row->title) ?></div>
                        <?php if ($row->duplicateIsbn || $row->existsInDb): ?>
                            <span class="badge bg-warning text-dark me-1">Duplicate ISBN</span>
                        <?php endif; ?>
                        <?php foreach ($row->errors as $e): ?>
                            <div class="text-danger small">• <?= Html::encode($e) ?></div>
                        <?php endforeach; ?>
                    </td>
                    <td><?= Html::encode(implode(', ', $row->authors)) ?></td>
                    <td>
                        <?= Html::encode($row->series ?? '') ?>
                        <?php if ($row->orderInSeries): ?>
                            <span class="text-muted">#<?= (int)$row->orderInSeries ?></span>
                        <?php endif; ?>
                    </td>
                    <td><?= Html::encode(implode(', ', $row->genres)) ?></td>
                    <td><?= Html::encode($row->publisher ?? '') ?></td>
                    <td><?= Html::encode($row->year ?? '') ?></td>
                    <td><?= Html::encode($row->isbn ?? '') ?></td>
                    <td><?= Html::encode($row->language ?? '') ?></td>
                    <td><?= Html::encode($row->itemType) ?></td>
                    <td><?= Html::encode($row->formatName ?? '') ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="card-body d-flex justify-content-between">
        <a href="<?= Url::to(['item/import']) ?>" class="btn btn-outline-secondary">
            <i class="bi bi-x-circle me-1"></i> Cancel
        </a>
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check2-circle me-1"></i> Import Selected
        </button>
    </div>
</form>

<script>
    (function(){
        const selectAll = document.getElementById('selectAll');
        const checks = document.querySelectorAll('.row-check');
        if (selectAll) {
            selectAll.addEventListener('change', function(){
                checks.forEach(cb => cb.checked = selectAll.checked);
            });
        }
    })();
</script>
