<?php

declare(strict_types=1);

/**
 * @var WebView $this
 * @var Yiisoft\Router\UrlGeneratorInterface $urlGenerator
 * @var string|null $csrf
 */

use Yiisoft\View\WebView;

$this->setTitle('Add New Item - Library');
?>

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 mb-1">
            <i class="bi bi-plus-circle text-primary me-2"></i>
            Add New Item
        </h1>
        <p class="text-muted mb-0">Add a new book, e-book, or audiobook to your library</p>
    </div>
    <a href="<?= $urlGenerator->generate('item/index') ?>" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Back to Library
    </a>
</div>

<!-- Progress Steps -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="row text-center">
            <div class="col-md-4">
                <div class="d-flex align-items-center justify-content-center">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                        <small class="fw-bold">1</small>
                    </div>
                    <span class="text-primary fw-semibold">Basic Information</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center justify-content-center">
                    <div class="bg-light text-muted rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                        <small class="fw-bold">2</small>
                    </div>
                    <span class="text-muted">Details & Metadata</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center justify-content-center">
                    <div class="bg-light text-muted rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                        <small class="fw-bold">3</small>
                    </div>
                    <span class="text-muted">Review & Save</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Form -->
<form method="post" enctype="multipart/form-data" id="itemForm">
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
                                   placeholder="Enter the book title" required>
                            <div class="invalid-feedback">
                                Please provide a valid title.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="format" class="form-label fw-semibold">
                                Format <span class="text-danger">*</span>
                            </label>
                            <select class="form-select form-select-lg" id="format" name="format_id" required>
                                <option value="">Choose format...</option>
                                <option value="1">Physical Book</option>
                                <option value="2">E-book (PDF)</option>
                                <option value="3">E-book (EPUB)</option>
                                <option value="4">E-book (MOBI)</option>
                                <option value="5">Audiobook (MP3)</option>
                                <option value="6">Audiobook (M4A)</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a format.
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="authors" class="form-label fw-semibold">
                                Authors <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="authors" name="authors"
                                   placeholder="Enter author names (comma separated)" required>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Separate multiple authors with commas
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="isbn" class="form-label fw-semibold">ISBN</label>
                            <input type="text" class="form-control" id="isbn" name="isbn"
                                   placeholder="978-0-123456-78-9">
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                ISBN-10 or ISBN-13 format
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4"
                                  placeholder="Enter a brief description of the book..."></textarea>
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
                            <label for="publisher" class="form-label fw-semibold">Publisher</label>
                            <input type="text" class="form-control" id="publisher" name="publisher"
                                   placeholder="Enter publisher name">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="publication_year" class="form-label fw-semibold">Publication Year</label>
                            <input type="number" class="form-control" id="publication_year" name="publication_year"
                                   min="1000" max="<?= date('Y') + 1 ?>" placeholder="<?= date('Y') ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="pages" class="form-label fw-semibold">Pages</label>
                            <input type="number" class="form-control" id="pages" name="pages"
                                   min="1" placeholder="0">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="genre" class="form-label fw-semibold">Genre</label>
                            <select class="form-select" id="genre" name="genre_id">
                                <option value="">Choose genre...</option>
                                <option value="1">Fiction</option>
                                <option value="2">Non-Fiction</option>
                                <option value="3">Science Fiction</option>
                                <option value="4">Fantasy</option>
                                <option value="5">Mystery</option>
                                <option value="6">Romance</option>
                                <option value="7">Biography</option>
                                <option value="8">History</option>
                                <option value="9">Science</option>
                                <option value="10">Technology</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="series" class="form-label fw-semibold">Series</label>
                            <input type="text" class="form-control" id="series" name="series"
                                   placeholder="Enter series name (if applicable)">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="language" class="form-label fw-semibold">Language</label>
                            <select class="form-select" id="language" name="language">
                                <option value="en" selected>English</option>
                                <option value="es">Spanish</option>
                                <option value="fr">French</option>
                                <option value="de">German</option>
                                <option value="it">Italian</option>
                                <option value="pt">Portuguese</option>
                                <option value="ru">Russian</option>
                                <option value="zh">Chinese</option>
                                <option value="ja">Japanese</option>
                                <option value="ko">Korean</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="rating" class="form-label fw-semibold">Your Rating</label>
                            <div class="rating-input">
                                <div class="btn-group" role="group" aria-label="Rating">
                                    <input type="radio" class="btn-check" name="rating" id="rating1" value="1">
                                    <label class="btn btn-outline-warning" for="rating1">
                                        <i class="bi bi-star"></i>
                                    </label>
                                    <input type="radio" class="btn-check" name="rating" id="rating2" value="2">
                                    <label class="btn btn-outline-warning" for="rating2">
                                        <i class="bi bi-star"></i>
                                    </label>
                                    <input type="radio" class="btn-check" name="rating" id="rating3" value="3">
                                    <label class="btn btn-outline-warning" for="rating3">
                                        <i class="bi bi-star"></i>
                                    </label>
                                    <input type="radio" class="btn-check" name="rating" id="rating4" value="4">
                                    <label class="btn btn-outline-warning" for="rating4">
                                        <i class="bi bi-star"></i>
                                    </label>
                                    <input type="radio" class="btn-check" name="rating" id="rating5" value="5">
                                    <label class="btn btn-outline-warning" for="rating5">
                                        <i class="bi bi-star"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
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
                         style="min-height: 200px; cursor: pointer;" onclick="document.getElementById('cover').click();">
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
                    <a href="<?= $urlGenerator->generate('item/index') ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-1"></i>Cancel
                    </a>
                    <button type="button" class="btn btn-outline-primary" onclick="saveDraft()">
                        <i class="bi bi-file-earmark me-1"></i>Save Draft
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i>Add to Library
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.getElementById('itemForm');
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
        input.addEventListener('change', function() {
            updateRatingDisplay(this.value);
        });
    });
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
    document.getElementById('authors').value = 'F. Scott Fitzgerald';
    document.getElementById('isbn').value = '978-0-7432-7356-5';
    document.getElementById('description').value = 'A classic American novel set in the Jazz Age, exploring themes of wealth, love, and the American Dream.';
    document.getElementById('publisher').value = 'Scribner';
    document.getElementById('publication_year').value = '1925';
    document.getElementById('pages').value = '180';
    document.getElementById('format').value = '1';
    document.getElementById('genre').value = '1';
    document.getElementById('language').value = 'en';
    document.getElementById('rating3').checked = true;
    updateRatingDisplay(3);
}

function clearForm() {
    if (confirm('Are you sure you want to clear all form data?')) {
        document.getElementById('itemForm').reset();
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

function saveDraft() {
    alert('Draft save functionality would be implemented here.');
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
