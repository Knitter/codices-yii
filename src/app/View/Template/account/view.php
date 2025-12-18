<?php

declare(strict_types=1);

/**
 * @var \yii\web\View $this
 * @var \Codices\Model\Account $account
 */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('codices', 'Account Details');
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2 mb-0">
        <i class="bi bi-person-badge me-2"></i>
        <?= Html::encode($this->title) ?>
    </h1>
    <div class="d-flex gap-2">
        <a class="btn btn-outline-secondary" href="<?= Url::to(['account/index']) ?>">
            <i class="bi bi-arrow-left me-1"></i> Back to Accounts
        </a>
        <a class="btn btn-primary" href="<?= Url::to(['account/edit', 'id' => $account->id]) ?>">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3 text-muted">ID</dt>
            <dd class="col-sm-9"><?= Html::encode((string)$account->id) ?></dd>

            <dt class="col-sm-3 text-muted">Username</dt>
            <dd class="col-sm-9"><?= Html::encode((string)$account->username) ?></dd>

            <dt class="col-sm-3 text-muted">Email</dt>
            <dd class="col-sm-9"><?= Html::encode((string)$account->email) ?></dd>

            <dt class="col-sm-3 text-muted">Name</dt>
            <dd class="col-sm-9"><?= Html::encode((string)$account->name) ?></dd>

            <dt class="col-sm-3 text-muted">Active</dt>
            <dd class="col-sm-9">
                <?php $isActive = (int)$account->active === 1; ?>
                <span class="badge bg-<?= $isActive ? 'success' : 'secondary' ?>"><?= $isActive ? 'Yes' : 'No' ?></span>
            </dd>
        </dl>
    </div>
</div>
