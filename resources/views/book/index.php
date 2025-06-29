<?php

declare(strict_types=1);

/**
 * @var WebView $this
 * @var Yiisoft\Router\UrlGeneratorInterface $urlGenerator
 * @var Yiisoft\Data\Paginator\OffsetPaginator $paginator
 * @var array $queryParams
 * @var array $genres
 * @var array $publishers
 * @var Yiisoft\Data\Reader\Sort $sort
 * @var string $currentSort
 * @var string $currentDirection
 */

use Yiisoft\View\WebView;
use Yiisoft\Html\Html;

$this->setTitle('Books Management');
?>

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-1">
            <i class="bi bi-book text-primary me-2"></i>
            Books Management
        </h1>
        <p class="text-muted mb-0">Manage your physical book collection with advanced filtering and search</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= $urlGenerator->generate('book/add') ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>Add New Book
        </a>
        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#filterModal">
            <i class="bi bi-funnel me-1"></i>Advanced Filters
        </button>
    </div>
</div>

<!-- Quick Search and Sort -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="get" class="row g-3">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control" name="title" placeholder="Search by title..."
                           value="<?= Html::encode($queryParams['title'] ?? '') ?>">
                </div>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="author" placeholder="Search by author..."
                       value="<?= Html::encode($queryParams['author'] ?? '') ?>">
            </div>
            <div class="col-md-2">
                <select class="form-select" name="sort">
                    <option value="title" <?= ($currentSort === 'title') ? 'selected' : '' ?>>Sort by Title</option>
                    <option value="publishYear" <?= ($currentSort === 'publishYear') ? 'selected' : '' ?>>Sort by Year
                    </option>
                    <option value="rating" <?= ($currentSort === 'rating') ? 'selected' : '' ?>>Sort by Rating</option>
                    <option value="addedOn" <?= ($currentSort === 'addedOn') ? 'selected' : '' ?>>Sort by Date Added
                    </option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" name="sort_dir">
                    <option value="asc" <?= ($currentDirection === 'asc') ? 'selected' : '' ?>>Ascending</option>
                    <option value="desc" <?= ($currentDirection === 'desc') ? 'selected' : '' ?>>Descending</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i>
                </button>
            </div>

            <!-- Hidden fields to preserve other filters -->
            <?php foreach (['genre_id', 'publisher_id', 'year_from', 'year_to', 'rating', 'per_page'] as $field): ?>
                <?php if (!empty($queryParams[$field])): ?>
                    <input type="hidden" name="<?= $field ?>" value="<?= Html::encode($queryParams[$field]) ?>">
                <?php endif; ?>
            <?php endforeach; ?>
        </form>
    </div>
</div>

<!-- Active Filters -->
<?php if (!empty(array_filter($queryParams))): ?>
    <div class="mb-3">
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <span class="text-muted small">Active filters:</span>
            <?php if (!empty($queryParams['title'])): ?>
                <span class="badge bg-primary">
                Title: <?= Html::encode($queryParams['title']) ?>
                <a href="<?= $urlGenerator->generate('book/index', array_diff_key($queryParams, ['title' => ''])) ?>"
                   class="text-white ms-1">×</a>
            </span>
            <?php endif; ?>
            <?php if (!empty($queryParams['author'])): ?>
                <span class="badge bg-success">
                Author: <?= Html::encode($queryParams['author']) ?>
                <a href="<?= $urlGenerator->generate('book/index', array_diff_key($queryParams, ['author' => ''])) ?>"
                   class="text-white ms-1">×</a>
            </span>
            <?php endif; ?>
            <?php if (!empty($queryParams['genre_id'])): ?>
                <span class="badge bg-info">
                Genre: <?= Html::encode($queryParams['genre_id']) ?>
                <a href="<?= $urlGenerator->generate('book/index', array_diff_key($queryParams, ['genre_id' => ''])) ?>"
                   class="text-white ms-1">×</a>
            </span>
            <?php endif; ?>
            <?php if (!empty($queryParams['publisher_id'])): ?>
                <span class="badge bg-warning">
                Publisher: <?= Html::encode($queryParams['publisher_id']) ?>
                <a href="<?= $urlGenerator->generate('book/index', array_diff_key($queryParams, ['publisher_id' => ''])) ?>"
                   class="text-white ms-1">×</a>
            </span>
            <?php endif; ?>
            <a href="<?= $urlGenerator->generate('book/index') ?>" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-x-circle me-1"></i>Clear All
            </a>
        </div>
    </div>
<?php endif; ?>

<!-- Results Info -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="text-muted">
        <small>
            Showing <?= $paginator->getOffset() + 1 ?>
            to <?= min($paginator->getOffset() + $paginator->getPageSize(), $paginator->getTotalItems()) ?>
            of <?= $paginator->getTotalItems() ?> books
        </small>
    </div>
    <div class="d-flex align-items-center gap-2">
        <small class="text-muted">Per page:</small>
        <form method="get" class="d-inline">
            <select name="per_page" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="10" <?= ($queryParams['per_page'] ?? 20) == 10 ? 'selected' : '' ?>>10</option>
                <option value="20" <?= ($queryParams['per_page'] ?? 20) == 20 ? 'selected' : '' ?>>20</option>
                <option value="50" <?= ($queryParams['per_page'] ?? 20) == 50 ? 'selected' : '' ?>>50</option>
                <option value="100" <?= ($queryParams['per_page'] ?? 20) == 100 ? 'selected' : '' ?>>100</option>
            </select>
            <!-- Preserve other query parameters -->
            <?php foreach (array_diff_key($queryParams, ['per_page' => '']) as $key => $value): ?>
                <input type="hidden" name="<?= $key ?>" value="<?= Html::encode($value) ?>">
            <?php endforeach; ?>
        </form>
    </div>
</div>

<!-- Books Grid -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <?php if ($paginator->getTotalItems() > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                    <tr>
                        <th>Cover</th>
                        <th>
                            <a href="<?= $urlGenerator->generate('book/index', array_merge($queryParams, ['sort' => 'title', 'sort_dir' => $currentSort === 'title' && $currentDirection === 'asc' ? 'desc' : 'asc'])) ?>"
                               class="text-decoration-none">
                                Title
                                <?php if ($currentSort === 'title'): ?>
                                    <i class="bi bi-chevron-<?= $currentDirection === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th>Authors</th>
                        <th>Publisher</th>
                        <th>
                            <a href="<?= $urlGenerator->generate('book/index', array_merge($queryParams, ['sort' => 'publishYear', 'sort_dir' => $currentSort === 'publishYear' && $currentDirection === 'asc' ? 'desc' : 'asc'])) ?>"
                               class="text-decoration-none">
                                Year
                                <?php if ($currentSort === 'publishYear'): ?>
                                    <i class="bi bi-chevron-<?= $currentDirection === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th>
                            <a href="<?= $urlGenerator->generate('book/index', array_merge($queryParams, ['sort' => 'rating', 'sort_dir' => $currentSort === 'rating' && $currentDirection === 'asc' ? 'desc' : 'asc'])) ?>"
                               class="text-decoration-none">
                                Rating
                                <?php if ($currentSort === 'rating'): ?>
                                    <i class="bi bi-chevron-<?= $currentDirection === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($paginator->read() as $book): ?>
                        <tr>
                            <td>
                                <div class="book-cover-small">
                                    <?php if ($book->cover): ?>
                                        <img src="<?= Html::encode($book->cover) ?>" alt="Cover" class="img-thumbnail"
                                             style="width: 40px; height: 60px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="bg-light border d-flex align-items-center justify-content-center"
                                             style="width: 40px; height: 60px;">
                                            <i class="bi bi-book text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <strong><?= Html::encode($book->title) ?></strong>
                                    <?php if ($book->subtitle): ?>
                                        <br><small class="text-muted"><?= Html::encode($book->subtitle) ?></small>
                                    <?php endif; ?>
                                    <?php if ($book->isbn): ?>
                                        <br><small class="text-muted">ISBN: <?= Html::encode($book->isbn) ?></small>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <?php $authors = $book->getAuthors()->all(); ?>
                                <?php if (!empty($authors)): ?>
                                    <?= Html::encode(implode(', ', array_map(fn($author) => $author->name, $authors))) ?>
                                <?php else: ?>
                                    <span class="text-muted">Unknown</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($book->publisher): ?>
                                    <?= Html::encode($book->publisher->name) ?>
                                <?php else: ?>
                                    <span class="text-muted">Unknown</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= $book->publishYear ? Html::encode($book->publishYear) : '<span class="text-muted">Unknown</span>' ?>
                            </td>
                            <td>
                                <?php if ($book->rating): ?>
                                    <div class="text-warning">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="bi bi-star<?= $i <= $book->rating ? '-fill' : '' ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                <?php else: ?>
                                    <span class="text-muted">Not rated</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <?php if ($book->read): ?>
                                        <span class="badge bg-success">Read</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Unread</span>
                                    <?php endif; ?>
                                    <?php if ($book->translated): ?>
                                        <span class="badge bg-info">Translated</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="<?= $urlGenerator->generate('book/edit', ['id' => $book->id]) ?>"
                                       class="btn btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-info" title="View Details"
                                            data-bs-toggle="modal" data-bs-target="#bookModal<?= $book->id ?>">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-danger" title="Delete"
                                            onclick="confirmDelete(<?= $book->id ?>, '<?= Html::encode($book->title) ?>')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <div class="display-1 text-muted mb-3">
                    <i class="bi bi-book"></i>
                </div>
                <h3 class="text-muted mb-3">No books found</h3>
                <p class="text-muted mb-4">
                    <?php if (!empty(array_filter($queryParams))): ?>
                        Try adjusting your search criteria or <a href="<?= $urlGenerator->generate('book/index') ?>">clear
                            all filters</a>.
                    <?php else: ?>
                        Start building your book collection by adding your first book.
                    <?php endif; ?>
                </p>
                <a href="<?= $urlGenerator->generate('book/add') ?>" class="btn btn-primary btn-lg">
                    <i class="bi bi-plus-circle me-2"></i>Add Your First Book
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Pagination -->
<?php if ($paginator->getTotalItems() > $paginator->getPageSize()): ?>
    <nav aria-label="Books pagination" class="mt-4">
        <ul class="pagination justify-content-center">
            <?php if ($paginator->getCurrentPage() > 1): ?>
                <li class="page-item">
                    <a class="page-link"
                       href="<?= $urlGenerator->generate('book/index', array_merge($queryParams, ['page' => $paginator->getCurrentPage() - 1])) ?>">
                        <i class="bi bi-chevron-left"></i> Previous
                    </a>
                </li>
            <?php endif; ?>

            <?php
            $startPage = max(1, $paginator->getCurrentPage() - 2);
            $endPage = min($paginator->getTotalPages(), $paginator->getCurrentPage() + 2);
            ?>

            <?php if ($startPage > 1): ?>
                <li class="page-item">
                    <a class="page-link"
                       href="<?= $urlGenerator->generate('book/index', array_merge($queryParams, ['page' => 1])) ?>">1</a>
                </li>
                <?php if ($startPage > 2): ?>
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                <?php endif; ?>
            <?php endif; ?>

            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                <li class="page-item <?= $i === $paginator->getCurrentPage() ? 'active' : '' ?>">
                    <a class="page-link"
                       href="<?= $urlGenerator->generate('book/index', array_merge($queryParams, ['page' => $i])) ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($endPage < $paginator->getTotalPages()): ?>
                <?php if ($endPage < $paginator->getTotalPages() - 1): ?>
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                <?php endif; ?>
                <li class="page-item">
                    <a class="page-link"
                       href="<?= $urlGenerator->generate('book/index', array_merge($queryParams, ['page' => $paginator->getTotalPages()])) ?>"><?= $paginator->getTotalPages() ?></a>
                </li>
            <?php endif; ?>

            <?php if ($paginator->getCurrentPage() < $paginator->getTotalPages()): ?>
                <li class="page-item">
                    <a class="page-link"
                       href="<?= $urlGenerator->generate('book/index', array_merge($queryParams, ['page' => $paginator->getCurrentPage() + 1])) ?>">
                        Next <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>

<!-- Advanced Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">
                    <i class="bi bi-funnel me-2"></i>Advanced Filters
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="get">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="genre_id" class="form-label">Genre</label>
                            <select class="form-select" name="genre_id" id="genre_id">
                                <option value="">All Genres</option>
                                <?php /*foreach ($genres as $genre): ?>
                                    <option
                                        value="<?= $genre->id ?>" <?= ($queryParams['genre_id'] ?? '') == $genre->id ? 'selected' : '' ?>>
                                        <?= Html::encode($genre->name) ?>
                                    </option>
                                <?php endforeach;*/ ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="publisher_id" class="form-label">Publisher</label>
                            <select class="form-select" name="publisher_id" id="publisher_id">
                                <option value="">All Publishers</option>
                                <?php /*foreach ($publishers as $publisher): ?>
                                    <option
                                        value="<?= $publisher->id ?>" <?= ($queryParams['publisher_id'] ?? '') == $publisher->id ? 'selected' : '' ?>>
                                        <?= Html::encode($publisher->name) ?>
                                    </option>
                                <?php endforeach;*/ ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="year_from" class="form-label">Publication Year From</label>
                            <input type="number" class="form-control" name="year_from" id="year_from"
                                   min="1000" max="<?= date('Y') ?>"
                                   value="<?= Html::encode($queryParams['year_from'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="year_to" class="form-label">Publication Year To</label>
                            <input type="number" class="form-control" name="year_to" id="year_to"
                                   min="1000" max="<?= date('Y') ?>"
                                   value="<?= Html::encode($queryParams['year_to'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="rating" class="form-label">Minimum Rating</label>
                            <select class="form-select" name="rating" id="rating">
                                <option value="">Any Rating</option>
                                <option value="1" <?= ($queryParams['rating'] ?? '') == '1' ? 'selected' : '' ?>>1 Star
                                    & Up
                                </option>
                                <option value="2" <?= ($queryParams['rating'] ?? '') == '2' ? 'selected' : '' ?>>2 Stars
                                    & Up
                                </option>
                                <option value="3" <?= ($queryParams['rating'] ?? '') == '3' ? 'selected' : '' ?>>3 Stars
                                    & Up
                                </option>
                                <option value="4" <?= ($queryParams['rating'] ?? '') == '4' ? 'selected' : '' ?>>4 Stars
                                    & Up
                                </option>
                                <option value="5" <?= ($queryParams['rating'] ?? '') == '5' ? 'selected' : '' ?>>5 Stars
                                    Only
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- Preserve existing search parameters -->
                    <input type="hidden" name="title" value="<?= Html::encode($queryParams['title'] ?? '') ?>">
                    <input type="hidden" name="author" value="<?= Html::encode($queryParams['author'] ?? '') ?>">
                    <input type="hidden" name="sort" value="<?= Html::encode($queryParams['sort'] ?? 'title') ?>">
                    <input type="hidden" name="sort_dir" value="<?= Html::encode($queryParams['sort_dir'] ?? 'asc') ?>">
                    <input type="hidden" name="per_page" value="<?= Html::encode($queryParams['per_page'] ?? '20') ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="<?= $urlGenerator->generate('book/index') ?>" class="btn btn-outline-secondary">Clear
                        All</a>
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id, title) {
        if (confirm(`Are you sure you want to delete "${title}"?`)) {
            // Create a form and submit it for deletion
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/book/delete/${id}`;

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_csrf';
            csrfInput.value = '<?= $csrf ?? '' ?>';
            form.appendChild(csrfInput);

            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
