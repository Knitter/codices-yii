<?php

declare(strict_types=1);

use Yiisoft\Html\Html;
use Yiisoft\Yii\Bootstrap5\Alert;

/**
 * @var \Yiisoft\View\View $this
 * @var \Yiisoft\Router\UrlGeneratorInterface $urlGenerator
 * @var array $errors
 */

$this->setTitle('Login');
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Login</h1>
            </div>
            <div class="card-body">
                <?php if (!empty($errors)): ?>
                    <?= Alert::widget()
                        ->options(['class' => 'alert-danger'])
                        ->body(Html::ul($errors))
                    ?>
                <?php endif; ?>

                <form method="post" action="/account/login">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe" value="1">
                        <label class="form-check-label" for="rememberMe">Remember Me</label>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>

                <div class="mt-3 text-center">
                    <a href="/account/forgot-password">Forgot Password?</a>
                </div>
            </div>
        </div>
    </div>
</div>
