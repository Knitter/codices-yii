<?php

namespace App\Asset;

use Yiisoft\Assets\AssetBundle;

final class AppAsset extends AssetBundle {

    public ?string $basePath = '@assets';
    public ?string $baseUrl = '@assetsUrl';
    public ?string $sourcePath = '@resources/assets/css';

    public array $css = [
        'site.css',
    ];
}
