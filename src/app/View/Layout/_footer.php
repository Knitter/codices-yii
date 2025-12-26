<?php

declare(strict_types=1);

/**
 * @var yii\web\View $this
 */

use yii\helpers\Url;

?>
<footer class="bg-light border-top mt-auto">
    <div class="container py-4">
        <div class="row">
            <div class="col-md-6">
                <h6 class="fw-bold text-primary">
                    <i class="bi bi-book-fill me-2"></i>
                    Codices
                </h6>
                <p class="text-muted small mb-0">
                    <?= Yii::t('codices', 'Modern book, e-book and audiobook management system') ?>
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <div class="btn-group" role="group" aria-label="Quick actions">
                    <a href="<?= Url::to('/item/add') ?>"
                       class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> <?= Yii::t('codices', 'Add Book') ?>
                    </a>
                    <a href="<?= Url::to('/app/search') ?>"
                       class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-search me-1"></i> <?= Yii::t('codices', 'Advanced Search') ?>
                    </a>
                </div>
            </div>
        </div>
        <hr class="my-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <small class="text-muted">
                    &copy; <?= date('Y') ?> Codices.
                    <?= Yii::t('codices', 'Built with {icon} using Yii2 & Bootstrap 5.', ['icon' => '<i class="bi bi-heart-fill text-danger"></i>']) ?>
                </small>
            </div>
            <div class="col-md-6 text-md-end">
                <button class="btn btn-sm btn-outline-secondary" id="themeToggle"
                        title="<?= Yii::t('codices', 'Toggle theme') ?>">
                    <i class="bi bi-sun-fill"></i>
                </button>
            </div>
        </div>
    </div>
</footer>
