<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\View\Helper;

use Yii;

final class Format {

    public static function attributeLabels(): array {
        return [
            'type' => Yii::t('codices', 'Type'),
            'name' => Yii::t('codices', 'Name'),
        ];
    }
}
