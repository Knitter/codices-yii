<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\View\Helper;

use Yii;

final class Publisher {

    public static function attributeLabels(): array {
        return [
            'id' => Yii::t('codices', 'No.'),
            'summary' => Yii::t('codices', 'Summary'),
            'website' => Yii::t('codices', 'Website'),
        ];
    }

}
