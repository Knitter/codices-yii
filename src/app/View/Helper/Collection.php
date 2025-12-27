<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\View\Helper;

use Yii;

final class Collection {

    public static function attributeLabels(): array {
        return [
            'id' => Yii::t('codices', 'No.'),
            'name' => Yii::t('codices', 'Name'),
            'publishDate' => Yii::t('codices', 'Publish Date'),
            'publishYear' => Yii::t('codices', 'Publish Year'),
            'description' => Yii::t('codices', 'Description'),
        ];
    }
}
