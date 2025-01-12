<?php

namespace App\ViewInjection;

use Yiisoft\Aliases\Aliases;
use Yiisoft\Assets\AssetManager;
use Yiisoft\I18n\Locale;
use Yiisoft\Router\CurrentRoute;
use Yiisoft\Yii\View\Renderer\LayoutParametersInjectionInterface;

final class LayoutViewInjection implements LayoutParametersInjectionInterface {

    private Aliases $aliases;
    private AssetManager $assetManager;
    private CurrentRoute $currentRoute;
    private Locale $locale;

    public function __construct(Aliases $aliases, AssetManager $assetManager, Locale $locale,
        CurrentRoute $currentRoute) {

        $this->locale = $locale;
        $this->currentRoute = $currentRoute;
        $this->assetManager = $assetManager;
        $this->aliases = $aliases;
    }

    public function getLayoutParameters(): array {
        return [
            'aliases' => $this->aliases,
            'assetManager' => $this->assetManager,
            'locale' => $this->locale,
            'currentRoute' => $this->currentRoute,
        ];
    }
}
