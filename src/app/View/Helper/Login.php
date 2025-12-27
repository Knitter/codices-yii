<?php

declare(strict_types=1);

namespace Codices\View\Helper;

use Yii;

final class Login {

    public static function attributeLabels(): array {
        return [
            'usernameOrEmail' => Yii::t('codices', 'Username or Email'),
            'password' => Yii::t('codices', 'Password'),
            'rememberMe' => Yii::t('codices', 'Remember me'),
        ];
    }
}
