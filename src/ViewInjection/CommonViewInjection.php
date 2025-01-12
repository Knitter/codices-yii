<?php

namespace App\ViewInjection;

use App\ApplicationParameters;
use Yiisoft\Yii\View\Renderer\CommonParametersInjectionInterface;
use Yiisoft\Router\UrlGeneratorInterface;

final class CommonViewInjection implements CommonParametersInjectionInterface {

    private ApplicationParameters $applicationParameters;
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(ApplicationParameters $applicationParameters, UrlGeneratorInterface $urlGenerator) {
        $this->urlGenerator = $urlGenerator;
        $this->applicationParameters = $applicationParameters;
    }

    public function getCommonParameters(): array {
        return [
            'applicationParameters' => $this->applicationParameters,
            'urlGenerator' => $this->urlGenerator,
        ];
    }
}
