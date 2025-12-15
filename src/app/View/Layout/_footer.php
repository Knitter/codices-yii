<footer class="bg-light border-top mt-auto">
    <div class="container py-4">
        <div class="row">
            <div class="col-md-6">
                <h6 class="fw-bold text-primary">
                    <i class="bi bi-book-fill me-2"></i>
                    <?php //= Html::encode($applicationParameters->getName()) ?>
                </h6>
                <p class="text-muted small mb-0">
                    Modern book, e-book and audiobook management system
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <div class="btn-group" role="group" aria-label="Quick actions">
                    <a href="<?php //= $urlGenerator->generate('item/create') ?>"
                       class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i>Add Book
                    </a>
                    <a href="<?php //= $urlGenerator->generate('item/search') ?>"
                       class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-search me-1"></i>Advanced Search
                    </a>
                </div>
            </div>
        </div>
        <hr class="my-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <small class="text-muted">
                    © <?= date('Y') ?> <?php //= Html::encode($applicationParameters->getName()) ?>.
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
