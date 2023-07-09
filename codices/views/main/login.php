<?php

/** @var yii\web\View $this */

$this->title = '';
?>
<div class="text-center mb-4">
    <a href="." class="navbar-brand navbar-brand-autodark">
        <img src="./static/logo.svg" height="36" alt="">
    </a>
</div>

<div class="card card-md">
    <div class="card-body">
        <h2 class="h2 text-center mb-4"><?= Yii::t('codices', 'Login to your account') ?></h2>
        <form action="#" method="get" autocomplete="off" novalidate>
            <div class="mb-3">
                <label class="form-label" for="email"><?= Yii::t('codices', 'Email address') ?></label>
                <input id="email" type="email" class="form-control" placeholder="your@email.com" autocomplete="off">
            </div>

            <div class="mb-2">
                <label class="form-label" for="password"><?= Yii::t('codices', 'Password') ?>
                    <span class="form-label-description">
                    <a href="#"><?= Yii::t('codices', 'I forgot password') ?></a>
                  </span>
                </label>
                <div class="input-group input-group-flat">
                    <input type="password" id="password" class="form-control"
                           placeholder="<?= Yii::t('codices', 'Your password') ?>"
                           autocomplete="off">
                    <span class="input-group-text">

                    <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip">
                        <!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                           stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                           stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path
                                  d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/><path
                                  d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                      </svg>
                    </a>
                  </span>
                </div>
            </div>

            <div class="mb-2">
                <label class="form-check">
                    <input type="checkbox" class="form-check-input"/>
                    <span class="form-check-label"><?= Yii::t('codices', 'Remember me on this device') ?></span>
                </label>
            </div>
            <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100"><?= Yii::t('codices', 'Sign in') ?></button>
            </div>
        </form>
    </div>
</div>
