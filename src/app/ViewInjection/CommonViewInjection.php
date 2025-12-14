<?php

declare(strict_types=1);

namespace Codices\ViewInjection;

use Codices\ApplicationParameters;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\Yii\View\Renderer\CommonParametersInjectionInterface;

final class CommonViewInjection implements CommonParametersInjectionInterface {

    public function __construct(private ApplicationParameters $applicationParameters,
                                private UrlGeneratorInterface $urlGenerator) {
    }

    public function getCommonParameters(): array {
        return [
            'applicationParameters' => $this->applicationParameters,
            'urlGenerator' => $this->urlGenerator,
        ];
    }
}
