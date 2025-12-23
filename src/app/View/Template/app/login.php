<?php

declare(strict_types=1);

/**
 * @var yii\web\View $this
 * @var Codices\View\Facade\LoginForm $login
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('codices', 'Codices: Login');
?>
<div class="container-fluid p-0">
    <div class="row login-container">
        <div class="col">
            <div class="login-form-container">
                <div class="login-card">
                    <div class="text-center mb-4">
                        <img src="/codices-logo.png">
                    </div>

                    <div class="text-center mb-4">
                        <p class="text-muted"><?= Yii::t('codices', 'Sign in to access your library') ?></p>
                    </div>

                    <?php $form = ActiveForm::begin(['options' => ['novalidate' => true]]); ?>
                    <div class="form-floating mb-3">
                        <?= Html::activeTextInput($login, 'usernameOrEmail', [
                            'class' => 'form-control',
                            'id' => 'username',
                            'placeholder' => Yii::t('codices', 'Username or Email'),
                            'required' => true,
                            'autocomplete' => 'username'
                        ]) ?>
                        <label for="username">
                            <i class="bi bi-person me-2"></i> <?= Yii::t('codices', 'Username or Email') ?>
                        </label>
                        <?php if ($login->hasErrors('usernameOrEmail')) { ?>
                            <div class="text-danger small mt-1">
                                <?= Html::encode(implode(' ', $login->getErrors('usernameOrEmail'))) ?>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="form-floating mb-4">
                        <?= Html::activePasswordInput($login, 'password', [
                            'class' => 'form-control',
                            'id' => 'password',
                            'placeholder' => Yii::t('codices', 'Password'),
                            'required' => true,
                            'autocomplete' => 'current-password',
                        ]) ?>
                        <label for="password">
                            <i class="bi bi-lock me-2"></i> <?= Yii::t('codices', 'Password') ?>
                        </label>
                        <?php if ($login->hasErrors('password')) { ?>
                            <div class="text-danger small mt-1">
                                <?= Html::encode(implode(' ', $login->getErrors('password'))) ?>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="form-check mb-4">
                        <?= Html::activeCheckbox($login, 'rememberMe', [
                            'class' => 'form-check-input',
                            'id' => 'remember',
                            'label' => Yii::t('codices', 'Remember me'),
                        ]) ?>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary btn-login">
                            <i class="bi bi-box-arrow-in-right me-2"></i>
                            <?= Yii::t('codices', 'Sign In') ?>
                        </button>
                    </div>

                    <div class="text-center">
                        <a href="#" class="text-decoration-none text-muted">
                            <i class="bi bi-question-circle me-1"></i>
                            <?= Yii::t('codices', 'Forgot your password?') ?>
                        </a>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
