<?php

namespace App\ViewInjection;

use Yiisoft\Translator\TranslatorInterface;
use Yiisoft\Yii\View\Renderer\CommonParametersInjectionInterface;

final class TranslatorViewInjection implements CommonParametersInjectionInterface {

    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator) {
        $this->translator = $translator;
    }

    public function getCommonParameters(): array {
        return [
            'translator' => $this->translator,
        ];
    }
}
