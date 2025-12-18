<?php

declare(strict_types=1);

/**
 * @var \yii\web\View $this
 * @var \Codices\View\Facade\ProfileForm $model
 * @var string $csrf
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

if (!isset($csrf)) {
    $csrf = Yii::$app->request->getCsrfToken();
}

$this->title = Yii::t('codices', 'Edit Profile');
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2 mb-0">
        <i class="bi bi-person-gear me-2"></i>
        <?= Html::encode($this->title) ?>
    </h1>
    <a href="<?= Url::to(['profile/view']) ?>" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Profile
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <?php $active = ActiveForm::begin(['options' => ['novalidate' => true]]); ?>
        <input type="hidden" name="_csrf" value="<?= $csrf ?>">

        <?= $active->field($model, 'username')->textInput(['placeholder' => 'e.g., slopes']) ?>
        <?= $active->field($model, 'email')->textInput(['placeholder' => 'you@example.com']) ?>
        <?= $active->field($model, 'name')->textInput(['placeholder' => 'e.g., Sérgio Lopes']) ?>

        <div class="d-flex justify-content-end gap-2">
            <a href="<?= Url::to(['profile/view']) ?>" class="btn btn-outline-secondary">
                <i class="bi bi-x-circle me-1"></i> Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle me-1"></i> Save Changes
            </button>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
