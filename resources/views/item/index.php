<?php

declare(strict_types=1);

/**
 * @var WebView $this
 * @var Yiisoft\Router\UrlGeneratorInterface $urlGenerator
 * @var Yiisoft\Data\Paginator\OffsetPaginator $paginator
 */

use Yiisoft\View\WebView;

$this->setTitle('Library - All Items');
?>

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-1">
            <i class="bi bi-collection-fill text-primary me-2"></i>
            Library Collection
        </h1>
        <p class="text-muted mb-0">Manage your books, e-books, and audiobooks</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= $urlGenerator->generate('item/create') ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>Add New Item
        </a>
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                <i class="bi bi-funnel me-1"></i>Filter
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="<?= $urlGenerator->generate('item/books') ?>">
                    <i class="bi bi-book me-2"></i>Books Only
                </a></li>
                <li><a class="dropdown-item" href="<?= $urlGenerator->generate('item/ebooks') ?>">
                    <i class="bi bi-tablet me-2"></i>E-books Only
                </a></li>
                <li><a class="dropdown-item" href="<?= $urlGenerator->generate('item/audiobooks') ?>">
                    <i class="bi bi-headphones me-2"></i>Audiobooks Only
                </a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="<?= $urlGenerator->generate('item/index') ?>">
                    <i class="bi bi-grid-3x3-gap me-2"></i>All Items
                </a></li>
            </ul>
        </div>
    </div>
</div>

<!-- Search and Sort Bar -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form class="row g-3" method="get">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control" name="search" placeholder="Search by title, author, or ISBN..."
                           value="<?= $_GET['search'] ?? '' ?>">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select" name="sort">
                    <option value="title" <?= ($_GET['sort'] ?? '') === 'title' ? 'selected' : '' ?>>Sort by Title</option>
                    <option value="author" <?= ($_GET['sort'] ?? '') === 'author' ? 'selected' : '' ?>>Sort by Author</option>
                    <option value="date" <?= ($_GET['sort'] ?? '') === 'date' ? 'selected' : '' ?>>Sort by Date Added</option>
                    <option value="rating" <?= ($_GET['sort'] ?? '') === 'rating' ? 'selected' : '' ?>>Sort by Rating</option>
                </select>
            </div>
            <div class="col-md-3">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        <i class="bi bi-search me-1"></i>Search
                    </button>
                    <a href="<?= $urlGenerator->generate('item/index') ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- View Toggle -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="text-muted">
        <small>Showing <strong>0</strong> items</small>
    </div>
    <div class="btn-group btn-group-sm" role="group">
        <input type="radio" class="btn-check" name="view" id="gridView" autocomplete="off" checked>
        <label class="btn btn-outline-secondary" for="gridView">
            <i class="bi bi-grid-3x3-gap"></i>
        </label>
        <input type="radio" class="btn-check" name="view" id="listView" autocomplete="off">
        <label class="btn btn-outline-secondary" for="listView">
            <i class="bi bi-list"></i>
        </label>
    </div>
</div>

<!-- Items Grid/List -->
<div id="itemsContainer">
    <!-- Grid View -->
    <div id="gridViewContent" class="row">
        <!-- Empty State -->
        <div class="col-12">
            <div class="text-center py-5">
                <div class="display-1 text-muted mb-3">
                    <i class="bi bi-book"></i>
                </div>
                <h3 class="text-muted mb-3">No items in your library yet</h3>
                <p class="text-muted mb-4">Start building your collection by adding your first book, e-book, or audiobook.</p>
                <a href="<?= $urlGenerator->generate('item/create') ?>" class="btn btn-primary btn-lg">
                    <i class="bi bi-plus-circle me-2"></i>Add Your First Item
                </a>
            </div>
        </div>

        <!-- Sample Item Cards (for demonstration) -->
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4" style="display: none;">
            <div class="card border-0 shadow-sm h-100 hover-lift">
                <div class="position-relative">
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                        <i class="bi bi-book text-muted" style="font-size: 4rem;"></i>
                    </div>
                    <div class="position-absolute top-0 end-0 m-2">
                        <span class="badge bg-primary">Book</span>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="card-title mb-2">Sample Book Title</h6>
                    <p class="card-text text-muted small mb-2">by Author Name</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-warning">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star"></i>
                        </div>
                        <div class="btn-group btn-group-sm">
                            <a href="#" class="btn btn-outline-primary">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="#" class="btn btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- List View -->
    <div id="listViewContent" class="d-none">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Type</th>
                                <th>Genre</th>
                                <th>Rating</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox display-4 d-block mb-2"></i>
                                    No items to display
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pagination -->
<nav aria-label="Items pagination" class="mt-4">
    <ul class="pagination justify-content-center">
        <li class="page-item disabled">
            <span class="page-link">Previous</span>
        </li>
        <li class="page-item active">
            <span class="page-link">1</span>
        </li>
        <li class="page-item disabled">
            <span class="page-link">Next</span>
        </li>
    </ul>
</nav>

<style>
.hover-lift {
    transition: transform 0.2s ease-in-out;
}
.hover-lift:hover {
    transform: translateY(-2px);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const gridViewBtn = document.getElementById('gridView');
    const listViewBtn = document.getElementById('listView');
    const gridContent = document.getElementById('gridViewContent');
    const listContent = document.getElementById('listViewContent');

    gridViewBtn.addEventListener('change', function() {
        if (this.checked) {
            gridContent.classList.remove('d-none');
            listContent.classList.add('d-none');
        }
    });

    listViewBtn.addEventListener('change', function() {
        if (this.checked) {
            listContent.classList.remove('d-none');
            gridContent.classList.add('d-none');
        }
    });
});
</script>
