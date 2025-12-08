<?php

declare(strict_types=1);

namespace App\app\Controller;

use Psr\Http\Message\ResponseInterface;
use Yiisoft\Yii\View\Renderer\ViewRenderer;

/**
 * @since 2025.1
 */
final class SiteController {

    public function __construct(private ViewRenderer $viewRenderer) {
        $this->viewRenderer = $viewRenderer->withControllerName('site');
    }

    public function index(): ResponseInterface {
        return $this->viewRenderer->render('index');
    }
}
