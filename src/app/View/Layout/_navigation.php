<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?php //= $urlGenerator->generate('home') ?>">
            <i class="bi bi-book-fill me-2"></i>
            <?php //= Html::encode($applicationParameters->getName()) ?>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php //= $urlGenerator->generate('home') ?>">
                        <i class="bi bi-house-fill me-1"></i>Home
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        <i class="bi bi-collection-fill me-1"></i>Library
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php //= $urlGenerator->generate('item/index') ?>">
                                <i class="bi bi-grid-3x3-gap-fill me-2"></i>All Items
                            </a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="<?php //= $urlGenerator->generate('item/books') ?>">
                                <i class="bi bi-book me-2"></i>Books
                            </a></li>
                        <li><a class="dropdown-item" href="<?php //= $urlGenerator->generate('item/ebooks') ?>">
                                <i class="bi bi-tablet me-2"></i>E-books
                            </a></li>
                        <li><a class="dropdown-item" href="<?php //= $urlGenerator->generate('item/audiobooks') ?>">
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
                        <li><a class="dropdown-item" href="<?php //= $urlGenerator->generate('author/index') ?>">
                                <i class="bi bi-person-fill me-2"></i>Authors
                            </a></li>
                        <li><a class="dropdown-item" href="<?php //= $urlGenerator->generate('publisher/index') ?>">
                                <i class="bi bi-building me-2"></i>Publishers
                            </a></li>
                        <li><a class="dropdown-item" href="<?php //= $urlGenerator->generate('genre/index') ?>">
                                <i class="bi bi-tags-fill me-2"></i>Genres
                            </a></li>
                        <li><a class="dropdown-item" href="<?php //= $urlGenerator->generate('series/index') ?>">
                                <i class="bi bi-collection me-2"></i>Series
                            </a></li>
                        <li><a class="dropdown-item" href="<?php //= $urlGenerator->generate('collection/index') ?>">
                                <i class="bi bi-folder-fill me-2"></i>Collections
                            </a></li>
                        <li><a class="dropdown-item" href="<?php //= $urlGenerator->generate('format/index') ?>">
                                <i class="bi bi-file-earmark-fill me-2"></i>Formats
                            </a></li>
                    </ul>
                </li>
            </ul>

            <!-- Search Form -->
            <form class="d-flex me-3" role="search" action="<?php //= $urlGenerator->generate('item/search') ?>"
                  method="get">
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
                        <li><a class="dropdown-item" href="<?php //= $urlGenerator->generate('account/index') ?>">
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
