<?php

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Yiisoft\Http\Status;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\Router\CurrentRoute;
use Yiisoft\Yii\View\Renderer\ViewRenderer;

final class NotFoundHandler implements RequestHandlerInterface {

    private UrlGeneratorInterface $urlGenerator;
    private ViewRenderer $viewRenderer;
    private CurrentRoute $currentRoute;

    public function __construct(UrlGeneratorInterface $urlGenerator, CurrentRoute $currentRoute,
                                ViewRenderer  $viewRenderer) {
        $this->currentRoute = $currentRoute;
        $this->viewRenderer = $viewRenderer;
        $this->urlGenerator = $urlGenerator;

        $this->viewRenderer = $viewRenderer->withControllerName('site');
    }

    public function handle(ServerRequestInterface $request): ResponseInterface {
        return $this->viewRenderer
            ->render('404', ['urlGenerator' => $this->urlGenerator, 'currentRoute' => $this->currentRoute])
            ->withStatus(Status::NOT_FOUND);
    }
}
