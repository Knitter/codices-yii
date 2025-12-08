<?php

declare(strict_types=1);

namespace App\app\ViewInjection;

use Yiisoft\Translator\TranslatorInterface;
use Yiisoft\Yii\View\Renderer\CommonParametersInjectionInterface;

/**
 * @since 2025.1
 */
final class TranslatorViewInjection implements CommonParametersInjectionInterface {

    public function __construct(private TranslatorInterface $translator) {
    }

    public function getCommonParameters(): array {
        return [
            'translator' => $this->translator,
        ];
    }
}
