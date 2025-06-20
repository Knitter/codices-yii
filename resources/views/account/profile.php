<?php

declare(strict_types=1);

use App\Model\Account;
use Yiisoft\Html\Html;
use Yiisoft\Yii\Bootstrap5\Alert;

/**
 * @var \Yiisoft\View\View $this
 * @var \Yiisoft\Router\UrlGeneratorInterface $urlGenerator
 * @var Account $account
 * @var array $errors
 */

$this->setTitle('My Profile');
?>

<h1>My Profile</h1>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Account Information</h2>
            </div>
            <div class="card-body">
                <?php if (!empty($errors)): ?>
                    <?= Alert::widget()
                        ->options(['class' => 'alert-danger'])
                        ->body(Html::ul($errors))
                    ?>
                <?php endif; ?>

                <?php if (!empty($success)): ?>
                    <?= Alert::widget()
                        ->options(['class' => 'alert-success'])
                        ->body($success)
                    ?>
                <?php endif; ?>

                <form method="post" action="/account/profile">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" value="<?= Html::encode($account->username) ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= Html::encode($account->email) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= Html::encode($account->name) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="currentPassword" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="currentPassword" name="currentPassword">
                        <div class="form-text">Required to change password.</div>
                    </div>

                    <div class="mb-3">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword">
                        <div class="form-text">Leave blank to keep current password. New password must be at least 6 characters long.</div>
                    </div>

                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
                    </div>

                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Statistics</h2>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Books
                        <span class="badge bg-primary rounded-pill"><?= count($account->getItems()->where(['type' => 'paper'])->all()) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        E-Books
                        <span class="badge bg-primary rounded-pill"><?= count($account->getItems()->where(['type' => 'ebook'])->all()) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Audiobooks
                        <span class="badge bg-primary rounded-pill"><?= count($account->getItems()->where(['type' => 'audio'])->all()) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Authors
                        <span class="badge bg-primary rounded-pill"><?= count($account->getAuthors()->all()) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Publishers
                        <span class="badge bg-primary rounded-pill"><?= count($account->getPublishers()->all()) ?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
