<?php

declare(strict_types=1);

/**
 * @var \yii\web\View $this
 * @var \Codices\View\Facade\Account $model
 * @var int $accountId
 * @var string $csrf
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

if (!isset($csrf)) {
    $csrf = Yii::$app->request->getCsrfToken();
}

$this->title = Yii::t('codices', 'Edit Account');
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2 mb-0">
        <i class="bi bi-pencil-square me-2"></i>
        <?= Html::encode($this->title) ?>
    </h1>
    <a href="<?= Url::to(['account/index']) ?>" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Accounts
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <?php $active = ActiveForm::begin(['options' => ['novalidate' => true]]); ?>
        <input type="hidden" name="_csrf" value="<?= $csrf ?>">

        <?= $active->field($model, 'username')->textInput(['placeholder' => 'e.g., alice']) ?>
        <?= $active->field($model, 'email')->textInput(['placeholder' => 'alice@example.com']) ?>
        <?= $active->field($model, 'name')->textInput(['placeholder' => 'e.g., Alice Smith']) ?>

        <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" role="switch" id="active" name="active" value="1" <?= $model->active ? 'checked' : '' ?>>
            <label class="form-check-label" for="active">Active</label>
        </div>

        <?= $active->field($model, 'password')->passwordInput([
            'autocomplete' => 'new-password',
            'placeholder' => 'Leave blank to keep current password',
        ])->hint('Leave blank to keep current password.') ?>
        <?= $active->field($model, 'confirmPassword')->passwordInput(['autocomplete' => 'new-password']) ?>

        <div class="d-flex justify-content-between">
            <a href="<?= Url::to(['account/delete', 'id' => $accountId]) ?>"
               class="btn btn-outline-danger"
               onclick="return confirm('Delete this account?');">
                <i class="bi bi-trash me-1"></i> Delete
            </a>
            <div class="d-flex gap-2">
                <a href="<?= Url::to(['account/index']) ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle me-1"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i> Save Changes
                </button>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
