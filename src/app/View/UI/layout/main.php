<?php

declare(strict_types=1);

use Codices\Asset\CodicesAsset;
use Yiisoft\Html\Html;
//use Yiisoft\I18n\Locale;

/**
 * @var \Codices\ApplicationParameters $applicationParameters
 * @var Yiisoft\Aliases\Aliases $aliases
 * @var Yiisoft\Assets\AssetManager $assetManager
 * @var string $content
 * @var string|null $csrf
 //* @var Locale $locale
 * @var Yiisoft\View\WebView $this
 * @var Yiisoft\Router\CurrentRoute $currentRoute
 * @var Yiisoft\Router\UrlGeneratorInterface $urlGenerator
 */

$assetManager->register(CodicesAsset::class);

$this->addCssFiles($assetManager->getCssFiles());
$this->addCssStrings($assetManager->getCssStrings());
$this->addJsFiles($assetManager->getJsFiles());
$this->addJsStrings($assetManager->getJsStrings());
$this->addJsVars($assetManager->getJsVars());

$this->beginPage()
?><!DOCTYPE html>
<html lang="<?php //= Html::encode($locale->language()) ?>" data-bs-theme="light">
<head>
    <meta charset="<?= Html::encode($applicationParameters->getCharset()) ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->getTitle()) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column min-vh-100">
<?php $this->beginBody() ?>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= $urlGenerator->generate('home') ?>">
            <i class="bi bi-book-fill me-2"></i>
            <?= Html::encode($applicationParameters->getName()) ?>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= $urlGenerator->generate('home') ?>">
                        <i class="bi bi-house-fill me-1"></i>Home
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        <i class="bi bi-collection-fill me-1"></i>Library
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= $urlGenerator->generate('item/index') ?>">
                                <i class="bi bi-grid-3x3-gap-fill me-2"></i>All Items
                            </a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="<?= $urlGenerator->generate('item/books') ?>">
                                <i class="bi bi-book me-2"></i>Books
                            </a></li>
                        <li><a class="dropdown-item" href="<?= $urlGenerator->generate('item/ebooks') ?>">
                                <i class="bi bi-tablet me-2"></i>E-books
                            </a></li>
                        <li><a class="dropdown-item" href="<?= $urlGenerator->generate('item/audiobooks') ?>">
                                <i class="bi bi-headphones me-2"></i>Audiobooks
                            </a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        <i class="bi bi-gear-fill me-1"></i>Manage
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= $urlGenerator->generate('author/index') ?>">
                                <i class="bi bi-person-fill me-2"></i>Authors
                            </a></li>
                        <li><a class="dropdown-item" href="<?= $urlGenerator->generate('publisher/index') ?>">
                                <i class="bi bi-building me-2"></i>Publishers
                            </a></li>
                        <li><a class="dropdown-item" href="<?= $urlGenerator->generate('genre/index') ?>">
                                <i class="bi bi-tags-fill me-2"></i>Genres
                            </a></li>
                        <li><a class="dropdown-item" href="<?= $urlGenerator->generate('series/index') ?>">
                                <i class="bi bi-collection me-2"></i>Series
                            </a></li>
                        <li><a class="dropdown-item" href="<?= $urlGenerator->generate('collection/index') ?>">
                                <i class="bi bi-folder-fill me-2"></i>Collections
                            </a></li>
                        <li><a class="dropdown-item" href="<?= $urlGenerator->generate('format/index') ?>">
                                <i class="bi bi-file-earmark-fill me-2"></i>Formats
                            </a></li>
                    </ul>
                </li>
            </ul>

            <!-- Search Form -->
            <form class="d-flex me-3" role="search" action="<?= $urlGenerator->generate('item/search') ?>" method="get">
                <div class="input-group">
                    <input class="form-control" type="search" name="q" placeholder="Search books..."
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
                        <i class="bi bi-person-circle me-1"></i>Account
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="<?= $urlGenerator->generate('account/index') ?>">
                                <i class="bi bi-person-gear me-2"></i>Profile
                            </a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<main class="flex-grow-1">
    <div class="container my-4">
        <?= $content ?>
    </div>
</main>

<!-- Footer -->
<footer class="bg-light border-top mt-auto">
    <div class="container py-4">
        <div class="row">
            <div class="col-md-6">
                <h6 class="fw-bold text-primary">
                    <i class="bi bi-book-fill me-2"></i>
                    <?= Html::encode($applicationParameters->getName()) ?>
                </h6>
                <p class="text-muted small mb-0">
                    Modern book, e-book and audiobook management system
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <div class="btn-group" role="group" aria-label="Quick actions">
                    <a href="<?= $urlGenerator->generate('item/create') ?>" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i>Add Book
                    </a>
                    <a href="<?= $urlGenerator->generate('item/search') ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-search me-1"></i>Advanced Search
                    </a>
                </div>
            </div>
        </div>
        <hr class="my-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <small class="text-muted">
                    © <?= date('Y') ?> <?= Html::encode($applicationParameters->getName()) ?>.
                    Built with <i class="bi bi-heart-fill text-danger"></i> using Yii3 & Bootstrap 5.
                </small>
            </div>
            <div class="col-md-6 text-md-end">
                <button class="btn btn-sm btn-outline-secondary" id="themeToggle" title="Toggle theme">
                    <i class="bi bi-sun-fill"></i>
                </button>
            </div>
        </div>
    </div>
</footer>

<!-- Theme Toggle Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const themeToggle = document.getElementById('themeToggle');
        const html = document.documentElement;
        const icon = themeToggle.querySelector('i');

        // Load saved theme or default to light
        const savedTheme = localStorage.getItem('theme') || 'light';
        html.setAttribute('data-bs-theme', savedTheme);
        updateIcon(savedTheme);

        themeToggle.addEventListener('click', function () {
            const currentTheme = html.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';

            html.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateIcon(newTheme);
        });

        function updateIcon(theme) {
            icon.className = theme === 'light' ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
            themeToggle.title = theme === 'light' ? 'Switch to dark theme' : 'Switch to light theme';
        }
    });
</script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
