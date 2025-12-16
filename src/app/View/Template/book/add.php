<?php

declare(strict_types=1);

/**
 * @var \yii\web\View $this
 * @var \Codices\Model\Item|\Codices\View\Facade\BookForm $item
 * @var \Codices\View\Facade\BookForm $model
 * @var array $authors
 * @var array $genres
 * @var array $publishers
 * @var array $series
 * @var array $collections
 * @var array $formats
 * @var string $csrf
 */

use yii\helpers\Html;
use yii\helpers\Url;

// Allow using new Form Model while keeping legacy template structure
if (!isset($item) && isset($model)) {
    $item = $model;
}
if (!isset($csrf)) {
    $csrf = Yii::$app->request->getCsrfToken();
}

$this->title = Yii::t('codices', 'Add New Book');
?>

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-1">
            <i class="bi bi-plus-circle text-primary me-2"></i>
            Add New Book
        </h1>
        <p class="text-muted mb-0">Add a new physical book to your library collection</p>
    </div>
    <a href="<?= Url::to('book/index') ?>" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Back to Books
    </a>
</div>

<!-- Progress Steps -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="row text-center">
            <div class="col-md-4">
                <div class="d-flex align-items-center justify-content-center">
                    <div
                        class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                        style="width: 30px; height: 30px;">
                        <small class="fw-bold">1</small>
                    </div>
                    <span class="text-primary fw-semibold">Basic Information</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center justify-content-center">
                    <div
                        class="bg-light text-muted rounded-circle d-flex align-items-center justify-content-center me-2"
                        style="width: 30px; height: 30px;">
                        <small class="fw-bold">2</small>
                    </div>
                    <span class="text-muted">Publication Details</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center justify-content-center">
                    <div
                        class="bg-light text-muted rounded-circle d-flex align-items-center justify-content-center me-2"
                        style="width: 30px; height: 30px;">
                        <small class="fw-bold">3</small>
                    </div>
                    <span class="text-muted">Additional Details</span>
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
                                   placeholder="Enter the book title" value="<?= Html::encode($item->title ?? '') ?>"
                                   required>
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
                                <?php /*foreach ($formats as $format): ?>
                                    <option value="<?= Html::encode($format->name) ?>"
                                            <?= ($item->format ?? '') === $format->name ? 'selected' : '' ?>>
                                        <?= Html::encode($format->name) ?>
                                    </option>
                                <?php endforeach;*/ ?>
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
                                <?php /*foreach ($authors as $author): ?>
                                    <option value="<?= $author->id ?>">
                                        <?= Html::encode($author->name) ?>
                                    </option>
                                <?php endforeach;*/ ?>
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
                                <?php /*foreach ($publishers as $publisher): ?>
                                    <option value="<?= $publisher->id ?>"
                                            <?= ($item->publisherId ?? '') == $publisher->id ? 'selected' : '' ?>>
                                        <?= Html::encode($publisher->name) ?>
                                    </option>
                                <?php endforeach;*/ ?>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="publishYear" class="form-label fw-semibold">Publication Year</label>
                            <input type="number" class="form-control" id="publishYear" name="publishYear"
                                   min="1000" max="<?= 1 + (int)date('Y') ?>" placeholder="<?= date('Y') ?>"
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
                                <option value="en" <?= ($item->language ?? 'en') === 'en' ? 'selected' : '' ?>>English
                                </option>
                                <option value="es" <?= ($item->language ?? '') === 'es' ? 'selected' : '' ?>>Spanish
                                </option>
                                <option value="fr" <?= ($item->language ?? '') === 'fr' ? 'selected' : '' ?>>French
                                </option>
                                <option value="de" <?= ($item->language ?? '') === 'de' ? 'selected' : '' ?>>German
                                </option>
                                <option value="it" <?= ($item->language ?? '') === 'it' ? 'selected' : '' ?>>Italian
                                </option>
                                <option value="pt" <?= ($item->language ?? '') === 'pt' ? 'selected' : '' ?>>
                                    Portuguese
                                </option>
                                <option value="ru" <?= ($item->language ?? '') === 'ru' ? 'selected' : '' ?>>Russian
                                </option>
                                <option value="zh" <?= ($item->language ?? '') === 'zh' ? 'selected' : '' ?>>Chinese
                                </option>
                                <option value="ja" <?= ($item->language ?? '') === 'ja' ? 'selected' : '' ?>>Japanese
                                </option>
                                <option value="ko" <?= ($item->language ?? '') === 'ko' ? 'selected' : '' ?>>Korean
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edition" class="form-label fw-semibold">Edition</label>
                            <input type="text" class="form-control" id="edition" name="edition"
                                   placeholder="e.g., 1st Edition, Revised Edition"
                                   value="<?= Html::encode($item->edition ?? '') ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="volume" class="form-label fw-semibold">Volume</label>
                            <input type="text" class="form-control" id="volume" name="volume"
                                   placeholder="e.g., Volume 1, Part A"
                                   value="<?= Html::encode($item->volume ?? '') ?>">
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
                                <?php /* foreach ($genres as $genre): ?>
                                    <option value="<?= $genre->id ?>">
                                        <?= Html::encode($genre->name) ?>
                                    </option>
                                <?php endforeach;*/ ?>
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
                                <?php /*foreach ($series as $serie): ?>
                                    <option value="<?= $serie->id ?>"
                                        <?= ($item->seriesId ?? '') == $serie->id ? 'selected' : '' ?>>
                                        <?= Html::encode($serie->name) ?>
                                    </option>
                                <?php endforeach;*/ ?>
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
                                <?php /*foreach ($collections as $collection): ?>
                                    <option value="<?= $collection->id ?>"
                                        <?= ($item->collectionId ?? '') == $collection->id ? 'selected' : '' ?>>
                                        <?= Html::encode($collection->name) ?>
                                    </option>
                                <?php endforeach;*/ ?>
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
                                        <input type="radio" class="btn-check" name="rating" id="rating<?= $i ?>"
                                               value="<?= $i ?>"
                                            <?= ($item->rating ?? 0) == $i ? 'checked' : '' ?>>
                                        <label class="btn btn-outline-warning" for="rating<?= $i ?>">
                                            <i class="bi bi-star"></i>
                                        </label>
                                    <?php endfor; ?>
                                </div>
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
                                    <input class="form-check-input" type="checkbox" id="translated" name="translated"
                                           value="1"
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
                                   placeholder="Original title (if translated)"
                                   value="<?= Html::encode($item->originalTitle ?? '') ?>">
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
            <!-- Cover Image -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-image text-info me-2"></i>
                        Cover Image
                    </h6>
                </div>
                <div class="card-body text-center">
                    <div class="cover-upload-area border border-2 border-dashed rounded p-4 mb-3"
                         style="min-height: 200px; cursor: pointer;"
                         onclick="document.getElementById('cover').click();">
                        <div class="d-flex flex-column align-items-center justify-content-center h-100">
                            <i class="bi bi-cloud-upload display-4 text-muted mb-2"></i>
                            <p class="text-muted mb-1">Click to upload cover image</p>
                            <small class="text-muted">JPG, PNG up to 5MB</small>
                        </div>
                    </div>
                    <input type="file" class="form-control d-none" id="cover" name="cover"
                           accept="image/jpeg,image/png,image/jpg">
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
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="fillSampleData()">
                            <i class="bi bi-magic me-1"></i>Fill Sample Data
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="clearForm()">
                            <i class="bi bi-arrow-clockwise me-1"></i>Clear Form
                        </button>
                        <button type="button" class="btn btn-outline-info btn-sm" onclick="importFromISBN()">
                            <i class="bi bi-download me-1"></i>Import from ISBN
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tips -->
            <div class="card border-0 bg-light">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="bi bi-lightbulb text-warning me-2"></i>
                        Tips
                    </h6>
                    <ul class="list-unstyled small mb-0">
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-1"></i>
                            Use descriptive titles for better organization
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-1"></i>
                            Add ISBN for automatic metadata lookup
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-1"></i>
                            Upload high-quality cover images
                        </li>
                        <li>
                            <i class="bi bi-check-circle text-success me-1"></i>
                            Rate books to track your favorites
                        </li>
                    </ul>
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
                    <a href="<?= Url::to('book/index') ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-1"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i>Add Book
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Form validation
        const form = document.getElementById('bookForm');
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });

        // Cover image preview
        document.getElementById('cover').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const uploadArea = document.querySelector('.cover-upload-area');
                    uploadArea.innerHTML = `
                    <img src="${e.target.result}" class="img-fluid rounded" style="max-height: 200px;">
                    <div class="mt-2">
                        <small class="text-muted">${file.name}</small>
                    </div>
                `;
                };
                reader.readAsDataURL(file);
            }
        });

        // Rating stars
        const ratingInputs = document.querySelectorAll('input[name="rating"]');
        ratingInputs.forEach(input => {
            input.addEventListener('change', function () {
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

    function fillSampleData() {
        document.getElementById('title').value = 'The Great Gatsby';
        document.getElementById('subtitle').value = 'A Classic American Novel';
        document.getElementById('plot').value = 'A classic American novel set in the Jazz Age, exploring themes of wealth, love, and the American Dream through the eyes of narrator Nick Carraway.';
        document.getElementById('isbn').value = '978-0-7432-7356-5';
        document.getElementById('publishYear').value = '1925';
        document.getElementById('pageCount').value = '180';
        document.getElementById('language').value = 'en';
        document.getElementById('edition').value = '1st Edition';
        document.getElementById('copies').value = '1';
        document.getElementById('rating3').checked = true;
        updateRatingDisplay(3);
    }

    function clearForm() {
        if (confirm('Are you sure you want to clear all form data?')) {
            document.getElementById('bookForm').reset();
            document.querySelector('.cover-upload-area').innerHTML = `
            <div class="d-flex flex-column align-items-center justify-content-center h-100">
                <i class="bi bi-cloud-upload display-4 text-muted mb-2"></i>
                <p class="text-muted mb-1">Click to upload cover image</p>
                <small class="text-muted">JPG, PNG up to 5MB</small>
            </div>
        `;
            updateRatingDisplay(0);
        }
    }

    function importFromISBN() {
        const isbn = document.getElementById('isbn').value;
        if (!isbn) {
            alert('Please enter an ISBN first.');
            return;
        }
        alert('ISBN import functionality would be implemented here.');
    }
</script>
