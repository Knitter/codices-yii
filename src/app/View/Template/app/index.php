<?php

declare(strict_types=1);

/**
 * @var \yii\web\View $this
 */

use yii\helpers\Url;

$this->title = Yii::t('codices', 'Dashboard');
?>
<!-- Hero Section -->
<div class="row mb-5">
    <div class="col-12">
        <div class="bg-primary text-white rounded-4 p-5 text-center position-relative overflow-hidden">
            <div class="position-relative z-1">
                <h1 class="display-4 fw-bold mb-3">
                    <i class="bi bi-book-fill me-3"></i>
                    <?= Yii::t('codices', 'Welcome to Codices') ?>
                </h1>
                <p class="lead mb-4">
                    <?= Yii::t('codices', 'Your comprehensive digital library management system for books, e-books, and audiobooks') ?>
                </p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="<?= Url::to('/item/add') ?>" class="btn btn-light btn-lg">
                        <i class="bi bi-plus-circle me-2"></i> <?= Yii::t('codices', 'Add New Book') ?>
                    </a>
                    <a href="<?= Url::to('/item/index') ?>" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-collection me-2"></i> <?= Yii::t('codices', 'Browse Library') ?>
                    </a>
                </div>
            </div>
            <!-- Background decoration -->
            <div class="position-absolute top-0 end-0 opacity-10">
                <i class="bi bi-book" style="font-size: 15rem;"></i>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-5">
    <div class="col-md-3 col-sm-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="display-4 text-primary mb-3">
                    <i class="bi bi-book"></i>
                </div>
                <h5 class="card-title"><?= Yii::t('codices', 'Physical Books') ?></h5>
                <p class="card-text display-6 fw-bold text-primary">0</p>
                <a href="<?= Url::to('/item/books') ?>" class="btn btn-outline-primary btn-sm">
                    <?= Yii::t('codices', 'View All') ?>
                    <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="display-4 text-success mb-3">
                    <i class="bi bi-tablet"></i>
                </div>
                <h5 class="card-title"><?= Yii::t('codices', 'E-books') ?></h5>
                <p class="card-text display-6 fw-bold text-success">0</p>
                <a href="<?= Url::to('/item/ebooks') ?>" class="btn btn-outline-success btn-sm">
                    <?= Yii::t('codices', 'View All') ?> <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="display-4 text-warning mb-3">
                    <i class="bi bi-headphones"></i>
                </div>
                <h5 class="card-title"><?= Yii::t('codices', 'Audiobooks') ?></h5>
                <p class="card-text display-6 fw-bold text-warning">0</p>
                <a href="<?= Url::to('/item/audiobooks') ?>"
                   class="btn btn-outline-warning btn-sm">
                    <?= Yii::t('codices', 'View All') ?> <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="display-4 text-info mb-3">
                    <i class="bi bi-collection-fill"></i>
                </div>
                <h5 class="card-title"><?= Yii::t('codices', 'Total Items') ?></h5>
                <p class="card-text display-6 fw-bold text-info">0</p>
                <a href="<?= Url::to('/item/index') ?>" class="btn btn-outline-info btn-sm">
                    <?= Yii::t('codices', 'View All') ?> <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-5" id="quick-actions">
    <div class="col-12">
        <h2 class="h3 mb-4">
            <i class="bi bi-lightning-fill text-warning me-2"></i>
            <?= Yii::t('codices', 'Quick Actions') ?>
        </h2>
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3" style="border-radius: 20%;">
                                <i class="bi bi-plus-circle text-primary fs-4"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-1"><?= Yii::t('codices', 'Add New Book') ?></h5>
                                <p class="card-text text-muted small mb-0"><?= Yii::t('codices', 'Add a new item to your library') ?></p>
                            </div>
                        </div>
                        <a href="<?= Url::to('/item/add') ?>" class="btn btn-primary w-100">
                            <?= Yii::t('codices', 'Get Started') ?> <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="bi bi-search text-success fs-4"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-1"><?= Yii::t('codices', 'Advanced Search') ?></h5>
                                <p class="card-text text-muted small mb-0"><?= Yii::t('codices', 'Find books by multiple criteria') ?></p>
                            </div>
                        </div>
                        <a href="<?= Url::to('/app/search') ?>" class="btn btn-success w-100">
                            <?= Yii::t('codices', 'Search Now') ?> <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-info bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="bi bi-person-plus text-info fs-4"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-1"><?= Yii::t('codices', 'Manage Authors') ?></h5>
                                <p class="card-text text-muted small mb-0"><?= Yii::t('codices', 'Add and organize book authors') ?></p>
                            </div>
                        </div>
                        <a href="<?= Url::to('/author/index') ?>" class="btn btn-info w-100">
                            <?= Yii::t('codices', 'Manage') ?> <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity / Getting Started -->
<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-0 pb-0">
                <h5 class="card-title mb-0">
                    <i class="bi bi-clock-history me-2"></i>
                    <?= Yii::t('codices', 'Getting Started') ?>
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item border-0 px-0">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bi bi-1-circle text-primary"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1"><?= Yii::t('codices', 'Set up your library') ?></h6>
                                <p class="mb-0 text-muted small"><?= Yii::t('codices', 'Start by adding your first book to the system') ?></p>
                            </div>
                            <a href="<?= Url::to('/item/add') ?>"
                               class="btn btn-sm btn-outline-primary">
                                <?= Yii::t('codices', 'Add Book') ?>
                            </a>
                        </div>
                    </div>
                    <div class="list-group-item border-0 px-0">
                        <div class="d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bi bi-2-circle text-success"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1"><?= Yii::t('codices', 'Organize your content') ?></h6>
                                <p class="mb-0 text-muted small"><?= Yii::t('codices', 'Create authors, publishers, and genres') ?></p>
                            </div>
                            <a href="<?= Url::to('/author/index') ?>"
                               class="btn btn-sm btn-outline-success">
                                <?= Yii::t('codices', 'Organize') ?>
                            </a>
                        </div>
                    </div>
                    <div class="list-group-item border-0 px-0">
                        <div class="d-flex align-items-center">
                            <div class="bg-info bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bi bi-3-circle text-info"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1"><?= Yii::t('codices', 'Explore features') ?></h6>
                                <p class="mb-0 text-muted small"><?= Yii::t('codices', 'Discover search, collections, and more') ?></p>
                            </div>
                            <a href="<?= Url::to('/app/search') ?>"
                               class="btn btn-sm btn-outline-info">
                                <?= Yii::t('codices', 'Explore') ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-0 pb-0">
                <h5 class="card-title mb-0">
                    <i class="bi bi-info-circle me-2"></i>
                    System Info
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Framework</span>
                    <span class="badge bg-primary">Yii3</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">PHP Version</span>
                    <span class="badge bg-success">8.4</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">UI Framework</span>
                    <span class="badge bg-info">Bootstrap 5</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted">Database</span>
                    <span class="badge bg-warning">SQLite</span>
                </div>
                <hr class="my-3">
                <div class="text-center">
                    <small class="text-muted">
                        <i class="bi bi-heart-fill text-danger me-1"></i>
                        <?= Yii::t('codices', 'Built with modern technologies') ?>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
