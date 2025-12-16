<?php

declare(strict_types=1);

/**
 * @var yii\web\View $this
 * @var string|null $csrf
 * @var array $errors
 * @var string $username
 */

//$this->setTitle('Login - ' . $applicationParameters->getName());
?>
<div class="container-fluid p-0">
    <div class="row g-0 login-container">
        <!-- Left Side - Image -->
        <div class="col-lg-6 d-none d-lg-block">
            <div class="login-image h-100">
                <div class="floating-books">
                    <i class="bi bi-book"></i>
                </div>
                <div class="floating-books">
                    <i class="bi bi-journal-bookmark"></i>
                </div>
                <div class="floating-books">
                    <i class="bi bi-book-half"></i>
                </div>
                <div class="floating-books">
                    <i class="bi bi-collection"></i>
                </div>

                <div class="login-image-content">
                    <div class="mb-4">
                        <i class="bi bi-book-fill" style="font-size: 4rem;"></i>
                    </div>
                    <h1 class="display-4 fw-bold mb-3">
                        <?php //= Html::encode($applicationParameters->getName()) ?>
                    </h1>
                    <p class="lead mb-4">
                        Your comprehensive digital library management system
                    </p>
                    <div class="d-flex justify-content-center gap-4 text-white-50">
                        <div class="text-center">
                            <i class="bi bi-book d-block mb-2" style="font-size: 2rem;"></i>
                            <small>Physical Books</small>
                        </div>
                        <div class="text-center">
                            <i class="bi bi-tablet d-block mb-2" style="font-size: 2rem;"></i>
                            <small>E-books</small>
                        </div>
                        <div class="text-center">
                            <i class="bi bi-headphones d-block mb-2" style="font-size: 2rem;"></i>
                            <small>Audiobooks</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="col-lg-6">
            <div class="login-form-container">
                <div class="login-card">
                    <!-- Mobile Header (visible only on small screens) -->
                    <div class="d-lg-none text-center mb-4">
                        <i class="bi bi-book-fill text-primary" style="font-size: 3rem;"></i>
                        <h2 class="h3 mt-2 mb-0"><?php //= Html::encode($applicationParameters->getName()) ?></h2>
                        <p class="text-muted">Digital Library Management</p>
                    </div>

                    <div class="text-center mb-4">
                        <h1 class="h2 fw-bold text-primary mb-2">Welcome Back</h1>
                        <p class="text-muted">Sign in to access your library</p>
                    </div>

                    <?php if (!empty($errors ?? [])): ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <?php foreach ($errors as $error): ?>
                                <div><?php //= Html::encode($error) ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?php //= $urlGenerator->generate('account/login') ?>">
                        <?php //= Html::hiddenInput('_csrf', $csrf) ?>

                        <div class="form-floating mb-3">
                            <input type="text"
                                   class="form-control"
                                   id="username"
                                   name="username"
                                   value="<?php //= Html::encode($username ?? '') ?>"
                                   placeholder="Username"
                                   required
                                   autocomplete="username">
                            <label for="username">
                                <i class="bi bi-person me-2"></i>Username
                            </label>
                        </div>

                        <div class="form-floating mb-4">
                            <input type="password"
                                   class="form-control"
                                   id="password"
                                   name="password"
                                   placeholder="Password"
                                   required
                                   autocomplete="current-password">
                            <label for="password">
                                <i class="bi bi-lock me-2"></i>Password
                            </label>
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember">
                            <label class="form-check-label" for="remember">
                                Remember me
                            </label>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-login">
                                <i class="bi bi-box-arrow-in-right me-2"></i>
                                Sign In
                            </button>
                        </div>

                        <div class="text-center">
                            <a href="#" class="text-decoration-none text-muted">
                                <i class="bi bi-question-circle me-1"></i>
                                Forgot your password?
                            </a>
                        </div>
                    </form>

                    <hr class="my-4">

                    <div class="text-center">
                        <small class="text-muted">
                            Don't have an account?
                            <a href="<?php //= $urlGenerator->generate('account/create') ?>"
                               class="text-primary text-decoration-none fw-semibold">
                                Create one here
                            </a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
