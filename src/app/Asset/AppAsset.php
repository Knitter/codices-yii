<?php

declare(strict_types=1);

namespace App\app\Asset;

use Yiisoft\Assets\AssetBundle;

/**
 * @since 2025.1
 */
final class AppAsset extends AssetBundle {

    public ?string $basePath = '@assets';
    public ?string $baseUrl = '@assetsUrl';
    public ?string $sourcePath = '@resources/assets/css';

    public array $css = [
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css',
        'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css',
        'site.css',
    ];

    public array $js = [
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js',
    ];
}
