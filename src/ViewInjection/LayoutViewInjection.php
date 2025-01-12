<?php

namespace App\ViewInjection;

use Yiisoft\Aliases\Aliases;
use Yiisoft\Assets\AssetManager;
use Yiisoft\I18n\Locale;
use Yiisoft\Router\CurrentRoute;
use Yiisoft\Yii\View\Renderer\LayoutParametersInjectionInterface;

final class LayoutViewInjection implements LayoutParametersInjectionInterface {

    public function __construct(private Aliases $aliases, private AssetManager $assetManager,
                                private Locale  $locale, private CurrentRoute $currentRoute) {
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
