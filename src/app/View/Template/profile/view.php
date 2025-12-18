<?php

declare(strict_types=1);

/**
 * @var \yii\web\View $this
 * @var \Codices\Model\Account $account
 */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('codices', 'My Profile');
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2 mb-0">
        <i class="bi bi-person-circle me-2"></i>
        <?= Html::encode($this->title) ?>
    </h1>
    <a href="<?= Url::to(['profile/edit']) ?>" class="btn btn-primary">
        <i class="bi bi-pencil me-1"></i> Edit Profile
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Username</dt>
            <dd class="col-sm-9"><?= Html::encode($account->username) ?></dd>

            <dt class="col-sm-3">Email</dt>
            <dd class="col-sm-9"><?= Html::encode($account->email) ?></dd>

            <dt class="col-sm-3">Name</dt>
            <dd class="col-sm-9"><?= Html::encode($account->name) ?></dd>
        </dl>
    </div>
</div>
