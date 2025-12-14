<?php

declare(strict_types=1);

namespace Codices\ViewInjection;

use Yiisoft\Aliases\Aliases;
use Yiisoft\Assets\AssetManager;
use Yiisoft\Router\CurrentRoute;
use Yiisoft\Yii\View\Renderer\LayoutParametersInjectionInterface;

final class LayoutViewInjection implements LayoutParametersInjectionInterface {

    public function __construct(private Aliases      $aliases, private AssetManager $assetManager,
                                private CurrentRoute $currentRoute) {
    }

    public function getLayoutParameters(): array {
        return [
            'aliases' => $this->aliases,
            'assetManager' => $this->assetManager,
            'currentRoute' => $this->currentRoute,
        ];
    }
}
