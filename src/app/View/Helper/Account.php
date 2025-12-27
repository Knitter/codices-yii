<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\View\Helper;

use Yii;

final class Account {

    public static function attributeLabels(): array {
        return [
            'id' => Yii::t('codices', 'No.'),
            'username' => Yii::t('codices', 'Username'),
            'email' => Yii::t('codices', 'Email'),
            'name' => Yii::t('codices', 'Name'),
            'active' => Yii::t('codices', 'Active'),
            'password' => Yii::t('codices', 'Password'),
            'confirmPassword' => Yii::t('codices', 'Confirm password'),
        ];
    }
}
