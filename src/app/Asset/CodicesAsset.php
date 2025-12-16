<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\Asset;

use yii\web\AssetBundle;

final class CodicesAsset extends AssetBundle {

    //public ?string $basePath = '@assets';
    //public ?string $baseUrl = '@assetsUrl';
    public $sourcePath = '@resources/assets/css';

    public $css = [
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css',
        'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css',
        'site.css',
    ];

    public $js = [
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js',
    ];
}
