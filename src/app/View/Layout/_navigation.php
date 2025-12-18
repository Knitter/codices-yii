<?php

declare(strict_types=1);

/**
 * @var yii\web\View $this
 */

use yii\helpers\Url;

?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= Url::to('/') ?>">
            <i class="bi bi-book-fill me-2"></i>
            Codices
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= Url::to('/') ?>">
                        <i class="bi bi-house-fill me-1"></i> <?= Yii::t('codices', 'Dashboard') ?>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        <i class="bi bi-collection-fill me-1"></i> <?= Yii::t('codices', 'Library') ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="<?= Url::to('/item/index') ?>">
                                <i class="bi bi-grid-3x3-gap-fill me-2"></i> <?= Yii::t('codices', 'All Items') ?>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= Url::to('/item/books') ?>">
                                <i class="bi bi-book me-2"></i> <?= Yii::t('codices', 'Books') ?>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= Url::to('/item/ebooks') ?>">
                                <i class="bi bi-tablet me-2"></i> <?= Yii::t('codices', 'E-books') ?>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= Url::to('/item/audiobooks') ?>">
                                <i class="bi bi-headphones me-2"></i> <?= Yii::t('codices', 'Audiobooks') ?>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= Url::to('/item/import') ?>">
                                <i class="bi bi-tablet me-2"></i> <?= Yii::t('codices', 'Import...') ?>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        <i class="bi bi-gear-fill me-1"></i> <?= Yii::t('codices', 'Manage') ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="<?= Url::to('/author/index') ?>">
                                <i class="bi bi-person-fill me-2"></i> <?= Yii::t('codices', 'Authors') ?>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= Url::to('/publisher/index') ?>">
                                <i class="bi bi-building me-2"></i> <?= Yii::t('codices', 'Publishers') ?>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= Url::to('/genre/index') ?>">
                                <i class="bi bi-tags-fill me-2"></i> <?= Yii::t('codices', 'Genres') ?>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= Url::to('/series/index') ?>">
                                <i class="bi bi-collection me-2"></i> <?= Yii::t('codices', 'Series') ?>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= Url::to('/collection/index') ?>">
                                <i class="bi bi-folder-fill me-2"></i> <?= Yii::t('codices', 'Collections') ?>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= Url::to('/format/index') ?>">
                                <i class="bi bi-file-earmark-fill me-2"></i> <?= Yii::t('codices', 'Formats') ?>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

            <!-- Search Form -->
            <form class="d-flex me-3" role="search" action="<?= Url::to('/app/search') ?>"
                  method="get">
                <div class="input-group">
                    <input class="form-control" type="search" name="q"
                           placeholder="<?= Yii::t('codices', 'Search...') ?>"
                           aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            <!-- User Menu -->
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        <i class="bi bi-person-circle me-1"></i> <?= Yii::t('codices', 'Account') ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="<?= Url::to('/account/index') ?>">
                                <i class="bi bi-person-gear me-2"></i> <?= Yii::t('codices', 'Profile') ?>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-box-arrow-right me-2"></i> <?= Yii::t('codices', 'Logout') ?>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
