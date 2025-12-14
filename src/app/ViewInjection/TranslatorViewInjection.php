<?php

declare(strict_types=1);

namespace Codices\ViewInjection;

use Yiisoft\Translator\TranslatorInterface;
use Yiisoft\Yii\View\Renderer\CommonParametersInjectionInterface;

final class TranslatorViewInjection implements CommonParametersInjectionInterface {

    public function __construct(private TranslatorInterface $translator) {
    }

    public function getCommonParameters(): array {
        return [
            'translator' => $this->translator,
        ];
    }
}
