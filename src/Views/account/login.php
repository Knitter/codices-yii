<?php

declare(strict_types=1);

/**
 * @var WebView $this
 * @var \App\ApplicationParameters $applicationParameters
 * @var Yiisoft\Router\UrlGeneratorInterface $urlGenerator
 * @var string|null $csrf
 * @var array $errors
 * @var string $username
 */

use Yiisoft\View\WebView;
use Yiisoft\Html\Html;

$this->setTitle('Login - ' . $applicationParameters->getName());
?>

<style>
.login-container {
    min-height: calc(100vh - 200px);
}

.login-image {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><pattern id="books" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse"><rect width="100" height="100" fill="%23ffffff" opacity="0.1"/><rect x="20" y="20" width="15" height="60" fill="%23ffffff" opacity="0.2"/><rect x="40" y="15" width="15" height="70" fill="%23ffffff" opacity="0.15"/><rect x="60" y="25" width="15" height="50" fill="%23ffffff" opacity="0.25"/></pattern></defs><rect width="1000" height="1000" fill="url(%23books)"/></svg>');
    background-size: 200px 200px;
    position: relative;
    overflow: hidden;
}

.login-image::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.3);
}

.login-image-content {
    position: relative;
    z-index: 2;
    color: white;
    text-align: center;
    padding: 2rem;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.login-form-container {
    background: #ffffff;
    padding: 3rem 2rem;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.login-card {
    max-width: 400px;
    margin: 0 auto;
}

.floating-books {
    position: absolute;
    font-size: 2rem;
    opacity: 0.1;
    animation: float 6s ease-in-out infinite;
}

.floating-books:nth-child(1) { top: 10%; left: 10%; animation-delay: 0s; }
.floating-books:nth-child(2) { top: 20%; right: 15%; animation-delay: 2s; }
.floating-books:nth-child(3) { bottom: 30%; left: 20%; animation-delay: 4s; }
.floating-books:nth-child(4) { bottom: 10%; right: 10%; animation-delay: 1s; }

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

@media (max-width: 768px) {
    .login-image {
        min-height: 300px;
    }

    .login-form-container {
        padding: 2rem 1rem;
    }

    .login-container {
        min-height: auto;
    }
}

.form-floating > .form-control:focus ~ label,
.form-floating > .form-control:not(:placeholder-shown) ~ label {
    opacity: .65;
    transform: scale(.85) translateY(-0.5rem) translateX(0.15rem);
}

.btn-login {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    padding: 0.75rem 2rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}
</style>

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
                        <?= Html::encode($applicationParameters->getName()) ?>
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
                        <h2 class="h3 mt-2 mb-0"><?= Html::encode($applicationParameters->getName()) ?></h2>
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
                                <div><?= Html::encode($error) ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?= $urlGenerator->generate('account/login') ?>">
                        <?= Html::hiddenInput('_csrf', $csrf) ?>

                        <div class="form-floating mb-3">
                            <input type="text"
                                   class="form-control"
                                   id="username"
                                   name="username"
                                   value="<?= Html::encode($username ?? '') ?>"
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
                            <a href="<?= $urlGenerator->generate('account/create') ?>" class="text-primary text-decoration-none fw-semibold">
                                Create one here
                            </a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
