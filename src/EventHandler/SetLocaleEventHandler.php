<?php

namespace App\EventHandler;

use Yiisoft\Translator\TranslatorInterface;
use Yiisoft\View\WebView;
use Yiisoft\Yii\Middleware\Event\SetLocaleEvent;

final class SetLocaleEventHandler {

    private TranslatorInterface $translator;
    private WebView $webView;

    public function __construct(TranslatorInterface $translator, WebView $webView) {
        $this->webView = $webView;
        $this->translator = $translator;
    }

    public function handle(SetLocaleEvent $event): void {
        $this->translator->setLocale($event->getLocale());
        $this->webView->setLocale($event->getLocale());
    }
}
