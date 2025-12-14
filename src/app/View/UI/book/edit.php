<?php

declare(strict_types=1);

/**
 * @var WebView $this
 * @var Yiisoft\Router\UrlGeneratorInterface $urlGenerator
 * @var \Codices\Model\Item $item
 * @var array $authors
 * @var array $genres
 * @var array $publishers
 * @var array $series
 * @var array $collections
 * @var array $formats
 * @var array $currentAuthors
 * @var array $currentGenres
 * @var string|null $csrf
 */

use Yiisoft\Html\Html;
use Yiisoft\View\WebView;

$this->setTitle('Edit Book - ' . ($item->title ?? 'Unknown'));
?>

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-1">
            <i class="bi bi-pencil text-primary me-2"></i>
            Edit Book
        </h1>
        <p class="text-muted mb-0">Update information for "<?= Html::encode($item->title ?? 'Unknown') ?>"</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= $urlGenerator->generate('book/index') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Back to Books
        </a>
        <button type="button" class="btn btn-outline-info" onclick="viewHistory()">
            <i class="bi bi-clock-history me-1"></i>History
        </button>
    </div>
</div>

<!-- Book Info Card -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-auto">
                <?php if ($item->cover): ?>
                    <img src="<?= Html::encode($item->cover) ?>" alt="Cover" class="img-thumbnail" style="width: 60px; height: 90px; object-fit: cover;">
                <?php else: ?>
                    <div class="bg-light border d-flex align-items-center justify-content-center" style="width: 60px; height: 90px;">
                        <i class="bi bi-book text-muted fs-4"></i>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col">
                <h5 class="mb-1"><?= Html::encode($item->title ?? 'Unknown') ?></h5>
                <?php if ($item->subtitle): ?>
                    <p class="text-muted mb-1"><?= Html::encode($item->subtitle) ?></p>
                <?php endif; ?>
                <div class="d-flex gap-3 text-muted small">
                    <?php if (!empty($currentAuthors)): ?>
                        <span><i class="bi bi-person me-1"></i><?= Html::encode(implode(', ', array_map(fn($author) => $author->name, $currentAuthors))) ?></span>
                    <?php endif; ?>
                    <?php if ($item->publishYear): ?>
                        <span><i class="bi bi-calendar me-1"></i><?= Html::encode($item->publishYear) ?></span>
                    <?php endif; ?>
                    <?php if ($item->isbn): ?>
                        <span><i class="bi bi-upc me-1"></i><?= Html::encode($item->isbn) ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-auto">
                <div class="text-end">
                    <small class="text-muted">Added: <?= Html::encode($item->addedOn ?? 'Unknown') ?></small>
                    <?php if ($item->rating): ?>
                        <div class="text-warning mt-1">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="bi bi-star<?= $i <= $item->rating ? '-fill' : '' ?>"></i>
                            <?php endfor; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<form method="post" enctype="multipart/form-data" id="bookForm" class="needs-validation" novalidate>
    <input type="hidden" name="_csrf" value="<?= $csrf ?>">

    <div class="row">
        <!-- Left Column - Main Form -->
        <div class="col-lg-8">
            <!-- Basic Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-info-circle text-primary me-2"></i>
                        Basic Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="title" class="form-label fw-semibold">
                                Title <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control form-control-lg" id="title" name="title"
                                   placeholder="Enter the book title" value="<?= Html::encode($item->title ?? '') ?>" required>
                            <div class="invalid-feedback">
                                Please provide a valid title.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="format" class="form-label fw-semibold">
                                Format
                            </label>
                            <select class="form-select" id="format" name="format">
                                <option value="">Choose format...</option>
                                <?php foreach ($formats as $format): ?>
                                    <option value="<?= Html::encode($format->name) ?>"
                                            <?= ($item->format ?? '') === $format->name ? 'selected' : '' ?>>
                                        <?= Html::encode($format->name) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="subtitle" class="form-label fw-semibold">Subtitle</label>
                        <input type="text" class="form-control" id="subtitle" name="subtitle"
                               placeholder="Enter subtitle (if any)" value="<?= Html::encode($item->subtitle ?? '') ?>">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="authors" class="form-label fw-semibold">
                                Authors <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="authors" name="authors[]" multiple required>
                                <?php
                                $currentAuthorIds = array_map(fn($author) => $author->id, $currentAuthors);
                                foreach ($authors as $author):
                                ?>
                                    <option value="<?= $author->id ?>"
                                            <?= in_array($author->id, $currentAuthorIds) ? 'selected' : '' ?>>
                                        <?= Html::encode($author->name) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Hold Ctrl/Cmd to select multiple authors
                            </div>
                            <div class="invalid-feedback">
                                Please select at least one author.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="isbn" class="form-label fw-semibold">ISBN</label>
                            <input type="text" class="form-control" id="isbn" name="isbn"
                                   placeholder="978-0-123456-78-9" value="<?= Html::encode($item->isbn ?? '') ?>">
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                ISBN-10 or ISBN-13 format
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="plot" class="form-label fw-semibold">Description/Plot</label>
                        <textarea class="form-control" id="plot" name="plot" rows="4"
                                  placeholder="Enter a brief description or plot summary..."><?= Html::encode($item->plot ?? '') ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Publication Details -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-building text-success me-2"></i>
                        Publication Details
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="publisherId" class="form-label fw-semibold">Publisher</label>
                            <select class="form-select" id="publisherId" name="publisherId">
                                <option value="">Choose publisher...</option>
                                <?php foreach ($publishers as $publisher): ?>
                                    <option value="<?= $publisher->id ?>"
                                            <?= ($item->publisherId ?? '') == $publisher->id ? 'selected' : '' ?>>
                                        <?= Html::encode($publisher->name) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="publishYear" class="form-label fw-semibold">Publication Year</label>
                            <input type="number" class="form-control" id="publishYear" name="publishYear"
                                   min="1000" max="<?= date('Y') + 1 ?>" placeholder="<?= date('Y') ?>"
                                   value="<?= Html::encode($item->publishYear ?? '') ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="pageCount" class="form-label fw-semibold">Pages</label>
                            <input type="number" class="form-control" id="pageCount" name="pageCount"
                                   min="1" placeholder="0" value="<?= Html::encode($item->pageCount ?? '') ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="publishDate" class="form-label fw-semibold">Publication Date</label>
                            <input type="date" class="form-control" id="publishDate" name="publishDate"
                                   value="<?= Html::encode($item->publishDate ?? '') ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="language" class="form-label fw-semibold">Language</label>
                            <select class="form-select" id="language" name="language">
                                <option value="en" <?= ($item->language ?? 'en') === 'en' ? 'selected' : '' ?>>English</option>
                                <option value="es" <?= ($item->language ?? '') === 'es' ? 'selected' : '' ?>>Spanish</option>
                                <option value="fr" <?= ($item->language ?? '') === 'fr' ? 'selected' : '' ?>>French</option>
                                <option value="de" <?= ($item->language ?? '') === 'de' ? 'selected' : '' ?>>German</option>
                                <option value="it" <?= ($item->language ?? '') === 'it' ? 'selected' : '' ?>>Italian</option>
                                <option value="pt" <?= ($item->language ?? '') === 'pt' ? 'selected' : '' ?>>Portuguese</option>
                                <option value="ru" <?= ($item->language ?? '') === 'ru' ? 'selected' : '' ?>>Russian</option>
                                <option value="zh" <?= ($item->language ?? '') === 'zh' ? 'selected' : '' ?>>Chinese</option>
                                <option value="ja" <?= ($item->language ?? '') === 'ja' ? 'selected' : '' ?>>Japanese</option>
                                <option value="ko" <?= ($item->language ?? '') === 'ko' ? 'selected' : '' ?>>Korean</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edition" class="form-label fw-semibold">Edition</label>
                            <input type="text" class="form-control" id="edition" name="edition"
                                   placeholder="e.g., 1st Edition, Revised Edition" value="<?= Html::encode($item->edition ?? '') ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="volume" class="form-label fw-semibold">Volume</label>
                            <input type="text" class="form-control" id="volume" name="volume"
                                   placeholder="e.g., Volume 1, Part A" value="<?= Html::encode($item->volume ?? '') ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Details -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-gear text-info me-2"></i>
                        Additional Details
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="genres" class="form-label fw-semibold">Genres</label>
                            <select class="form-select" id="genres" name="genres[]" multiple>
                                <?php
                                $currentGenreIds = array_map(fn($genre) => $genre->id, $currentGenres);
                                foreach ($genres as $genre):
                                ?>
                                    <option value="<?= $genre->id ?>"
                                            <?= in_array($genre->id, $currentGenreIds) ? 'selected' : '' ?>>
                                        <?= Html::encode($genre->name) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Hold Ctrl/Cmd to select multiple genres
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="seriesId" class="form-label fw-semibold">Series</label>
                            <select class="form-select" id="seriesId" name="seriesId">
                                <option value="">Not part of a series</option>
                                <?php foreach ($series as $serie): ?>
                                    <option value="<?= $serie->id ?>"
                                            <?= ($item->seriesId ?? '') == $serie->id ? 'selected' : '' ?>>
                                        <?= Html::encode($serie->name) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="orderInSeries" class="form-label fw-semibold">Order in Series</label>
                            <input type="number" class="form-control" id="orderInSeries" name="orderInSeries"
                                   min="1" placeholder="1" value="<?= Html::encode($item->orderInSeries ?? '') ?>">
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Only applicable if book is part of a series
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="collectionId" class="form-label fw-semibold">Collection</label>
                            <select class="form-select" id="collectionId" name="collectionId">
                                <option value="">No collection</option>
                                <?php foreach ($collections as $collection): ?>
                                    <option value="<?= $collection->id ?>"
                                            <?= ($item->collectionId ?? '') == $collection->id ? 'selected' : '' ?>>
                                        <?= Html::encode($collection->name) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="copies" class="form-label fw-semibold">Number of Copies</label>
                            <input type="number" class="form-control" id="copies" name="copies"
                                   min="1" value="<?= Html::encode($item->copies ?? 1) ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="rating" class="form-label fw-semibold">Your Rating</label>
                            <div class="rating-input">
                                <div class="btn-group" role="group" aria-label="Rating">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <input type="radio" class="btn-check" name="rating" id="rating<?= $i ?>" value="<?= $i ?>"
                                               <?= ($item->rating ?? 0) == $i ? 'checked' : '' ?>>
                                        <label class="btn btn-outline-warning" for="rating<?= $i ?>">
                                            <i class="bi bi-star"></i>
                                        </label>
                                    <?php endfor; ?>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-secondary ms-2" onclick="clearRating()">
                                    <i class="bi bi-x"></i> Clear
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Status</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="read" name="read" value="1"
                                           <?= ($item->read ?? false) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="read">
                                        Read
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="translated" name="translated" value="1"
                                           <?= ($item->translated ?? false) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="translated">
                                        Translated
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="originalTitle" class="form-label fw-semibold">Original Title</label>
                            <input type="text" class="form-control" id="originalTitle" name="originalTitle"
                                   placeholder="Original title (if translated)" value="<?= Html::encode($item->originalTitle ?? '') ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="url" class="form-label fw-semibold">URL</label>
                            <input type="url" class="form-control" id="url" name="url"
                                   placeholder="https://example.com" value="<?= Html::encode($item->url ?? '') ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="review" class="form-label fw-semibold">Your Review</label>
                        <textarea class="form-control" id="review" name="review" rows="3"
                                  placeholder="Write your personal review or notes..."><?= Html::encode($item->review ?? '') ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Additional Options -->
        <div class="col-lg-4">
            <!-- Current Cover -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-image text-info me-2"></i>
                        Cover Image
                    </h6>
                </div>
                <div class="card-body text-center">
                    <div class="current-cover mb-3">
                        <?php if ($item->cover): ?>
                            <img src="<?= Html::encode($item->cover) ?>" alt="Current Cover" class="img-fluid rounded" style="max-height: 200px;">
                            <div class="mt-2">
                                <small class="text-muted">Current cover</small>
                            </div>
                        <?php else: ?>
                            <div class="bg-light border d-flex align-items-center justify-content-center rounded" style="height: 200px;">
                                <div class="text-center">
                                    <i class="bi bi-image display-4 text-muted mb-2"></i>
                                    <p class="text-muted mb-0">No cover image</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="cover-upload-area border border-2 border-dashed rounded p-3 mb-3"
                         style="cursor: pointer;" onclick="document.getElementById('cover').click();">
                        <div class="d-flex flex-column align-items-center justify-content-center">
                            <i class="bi bi-cloud-upload fs-4 text-muted mb-1"></i>
                            <p class="text-muted mb-0 small">Click to upload new cover</p>
                            <small class="text-muted">JPG, PNG up to 5MB</small>
                        </div>
                    </div>
                    <input type="file" class="form-control d-none" id="cover" name="cover"
                           accept="image/jpeg,image/png,image/jpg">

                    <?php if ($item->cover): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="removeCover" name="removeCover" value="1">
                            <label class="form-check-label text-danger" for="removeCover">
                                Remove current cover
                            </label>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-lightning text-warning me-2"></i>
                        Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-outline-success btn-sm" onclick="markAsRead()">
                            <i class="bi bi-check-circle me-1"></i>Mark as Read
                        </button>
                        <button type="button" class="btn btn-outline-info btn-sm" onclick="duplicateBook()">
                            <i class="bi bi-files me-1"></i>Duplicate Book
                        </button>
                        <button type="button" class="btn btn-outline-warning btn-sm" onclick="resetForm()">
                            <i class="bi bi-arrow-clockwise me-1"></i>Reset Changes
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="deleteBook()">
                            <i class="bi bi-trash me-1"></i>Delete Book
                        </button>
                    </div>
                </div>
            </div>

            <!-- Book Statistics -->
            <div class="card border-0 bg-light">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="bi bi-graph-up text-info me-2"></i>
                        Book Statistics
                    </h6>
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <div class="h5 mb-0"><?= Html::encode($item->copies ?? 1) ?></div>
                                <small class="text-muted">Copies</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="h5 mb-0"><?= Html::encode($item->pageCount ?? 'N/A') ?></div>
                            <small class="text-muted">Pages</small>
                        </div>
                    </div>
                    <hr class="my-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">Added</small>
                        <small><?= Html::encode($item->addedOn ?? 'Unknown') ?></small>
                    </div>
                    <?php if ($item->publishYear): ?>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">Published</small>
                            <small><?= Html::encode($item->publishYear) ?></small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    <small>
                        <i class="bi bi-info-circle me-1"></i>
                        Fields marked with <span class="text-danger">*</span> are required
                    </small>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?= $urlGenerator->generate('book/index') ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-1"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i>Update Book
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.getElementById('bookForm');
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    });

    // Cover image preview
    document.getElementById('cover').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const uploadArea = document.querySelector('.cover-upload-area');
                uploadArea.innerHTML = `
                    <img src="${e.target.result}" class="img-fluid rounded" style="max-height: 120px;">
                    <div class="mt-2">
                        <small class="text-muted">${file.name}</small>
                    </div>
                `;
                // Uncheck remove cover if new image is selected
                const removeCoverElement = document.getElementById('removeCover');
                if (removeCoverElement) {
                    removeCoverElement.checked = false;
                }
            };
            reader.readAsDataURL(file);
        }
    });

    // Rating stars
    const ratingInputs = document.querySelectorAll('input[name="rating"]');
    ratingInputs.forEach(input => {
        input.addEventListener('change', function() {
            updateRatingDisplay(this.value);
        });
    });

    // Initialize rating display
    const checkedRating = document.querySelector('input[name="rating"]:checked');
    if (checkedRating) {
        updateRatingDisplay(checkedRating.value);
    }
});

function updateRatingDisplay(rating) {
    const labels = document.querySelectorAll('.rating-input label');
    labels.forEach((label, index) => {
        const icon = label.querySelector('i');
        if (index < rating) {
            icon.className = 'bi bi-star-fill';
            label.classList.remove('btn-outline-warning');
            label.classList.add('btn-warning');
        } else {
            icon.className = 'bi bi-star';
            label.classList.remove('btn-warning');
            label.classList.add('btn-outline-warning');
        }
    });
}

function clearRating() {
    const ratingInputs = document.querySelectorAll('input[name="rating"]');
    ratingInputs.forEach(input => input.checked = false);
    updateRatingDisplay(0);
}

function markAsRead() {
    document.getElementById('read').checked = true;
}

function duplicateBook() {
    if (confirm('Create a duplicate of this book?')) {
        window.location.href = '<?= $urlGenerator->generate('book/add') ?>?duplicate=<?= $item->id ?>';
    }
}

function resetForm() {
    if (confirm('Reset all changes? This will restore the original values.')) {
        location.reload();
    }
}

function deleteBook() {
    if (confirm('Are you sure you want to delete this book? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/book/delete/<?= $item->id ?>';

        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_csrf';
        csrfInput.value = '<?= $csrf ?? '' ?>';
        form.appendChild(csrfInput);

        document.body.appendChild(form);
        form.submit();
    }
}

function viewHistory() {
    alert('History functionality would be implemented here.');
}
</script>

<style>
.cover-upload-area:hover {
    background-color: #f8f9fa;
    border-color: #0d6efd !important;
}

.rating-input .btn {
    border-radius: 0;
}

.rating-input .btn:first-child {
    border-top-left-radius: 0.375rem;
    border-bottom-left-radius: 0.375rem;
}

.rating-input .btn:last-child {
    border-top-right-radius: 0.375rem;
    border-bottom-right-radius: 0.375rem;
}
</style>
