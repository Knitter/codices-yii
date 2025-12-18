<?php

declare(strict_types=1);

/**
 * @var yii\web\View $this
 * @var string|null $csrf
 * @var \Codices\View\Facade\LoginForm $model
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('codices', 'Codices: Login');
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
                    <h1 class="display-4 fw-bold mb-3">Codices</h1>
                    <p class="lead mb-4">
                        <?= Yii::t('codices', 'Your comprehensive digital library management system') ?>
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

                    <?php $form = ActiveForm::begin(['options' => ['novalidate' => true]]); ?>
                        <input type="hidden" name="_csrf" value="<?= Html::encode($csrf ?? Yii::$app->request->getCsrfToken()) ?>">

                        <div class="form-floating mb-3">
                            <?= Html::activeTextInput($model, 'usernameOrEmail', [
                                'class' => 'form-control',
                                'id' => 'username',
                                'placeholder' => 'Username or Email',
                                'required' => true,
                                'autocomplete' => 'username',
                            ]) ?>
                            <label for="username">
                                <i class="bi bi-person me-2"></i>Username or Email
                            </label>
                            <?php if ($model->hasErrors('usernameOrEmail')): ?>
                                <div class="text-danger small mt-1"><?= Html::encode(implode(' ', $model->getErrors('usernameOrEmail'))) ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="form-floating mb-4">
                            <?= Html::activePasswordInput($model, 'password', [
                                'class' => 'form-control',
                                'id' => 'password',
                                'placeholder' => 'Password',
                                'required' => true,
                                'autocomplete' => 'current-password',
                            ]) ?>
                            <label for="password">
                                <i class="bi bi-lock me-2"></i>Password
                            </label>
                            <?php if ($model->hasErrors('password')): ?>
                                <div class="text-danger small mt-1"><?= Html::encode(implode(' ', $model->getErrors('password'))) ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="form-check mb-4">
                            <?= Html::activeCheckbox($model, 'rememberMe', [
                                'class' => 'form-check-input',
                                'id' => 'remember',
                                'label' => 'Remember me',
                            ]) ?>
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
                    <?php ActiveForm::end(); ?>

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
