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

$this->setTitle('Update Account: ' . Html::encode($account->username));
?>

<h1>Update Account: <?= Html::encode($account->username) ?></h1>

<p>
    <?= Html::a('View', '/account/view/' . $account->id, ['class' => 'btn btn-info']) ?>
    <?= Html::a('Back to List', '/account', ['class' => 'btn btn-secondary']) ?>
</p>

<div class="card">
    <div class="card-body">
        <?php if (!empty($errors)): ?>
            <?= Alert::widget()
                ->options(['class' => 'alert-danger'])
                ->body(Html::ul($errors))
            ?>
        <?php endif; ?>

        <form method="post" action="/account/update/<?= $account->id ?>">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= Html::encode($account->username) ?>" required>
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
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
                <div class="form-text">Leave blank to keep current password. New password must be at least 6 characters long.</div>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="active" name="active" value="1" <?= $account->active ? 'checked' : '' ?>>
                <label class="form-check-label" for="active">Active</label>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
