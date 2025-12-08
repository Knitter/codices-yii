<?php

declare(strict_types=1);

use App\app\Controller\AccountController;
use App\app\Controller\AuthorController;
use App\app\Controller\BookController;
use App\app\Controller\CollectionController;
use App\app\Controller\FormatController;
use App\app\Controller\GenreController;
use App\app\Controller\ItemController;
use App\app\Controller\PublisherController;
use App\app\Controller\SeriesController;
use App\app\Controller\SiteController;
use Yiisoft\Router\Group;
use Yiisoft\Router\Route;

return [
    Group::create()
        ->routes(
            // Site routes
            Route::get('/')->action([SiteController::class, 'index'])->name('home'),

            // Account routes
            Route::get('/account')->action([AccountController::class, 'index'])->name('account/index'),
            Route::get('/account/view/{id:\d+}')->action([AccountController::class, 'view'])->name('account/view'),
            Route::methods(['GET', 'POST'], '/account/create')->action([AccountController::class, 'create'])->name('account/create'),
            Route::methods(['GET', 'POST'], '/account/update/{id:\d+}')->action([AccountController::class, 'update'])->name('account/update'),
            Route::post('/account/delete/{id:\d+}')->action([AccountController::class, 'delete'])->name('account/delete'),
            Route::methods(['GET', 'POST'], '/account/login')->action([AccountController::class, 'login'])->name('account/login'),
            Route::get('/account/profile')->action([AccountController::class, 'profile'])->name('account/profile'),

            // Author routes
            Route::get('/author')->action([AuthorController::class, 'index'])->name('author/index'),
            Route::get('/author/view/{id:\d+}')->action([AuthorController::class, 'view'])->name('author/view'),
            Route::methods(['GET', 'POST'], '/author/create')->action([AuthorController::class, 'create'])->name('author/create'),
            Route::methods(['GET', 'POST'], '/author/update/{id:\d+}')->action([AuthorController::class, 'update'])->name('author/update'),
            Route::post('/author/delete/{id:\d+}')->action([AuthorController::class, 'delete'])->name('author/delete'),

            // Book routes
            Route::get('/book')->action([BookController::class, 'index'])->name('book/index'),
            Route::methods(['GET', 'POST'], '/book/add')->action([BookController::class, 'add'])->name('book/add'),
            Route::methods(['GET', 'POST'], '/book/edit/{id:\d+}')->action([BookController::class, 'edit'])->name('book/edit'),
            Route::post('/book/delete/{id:\d+}')->action([BookController::class, 'delete'])->name('book/delete'),

            // Collection routes
            Route::get('/collection')->action([CollectionController::class, 'index'])->name('collection/index'),
            Route::get('/collection/view/{id:\d+}')->action([CollectionController::class, 'view'])->name('collection/view'),
            Route::methods(['GET', 'POST'], '/collection/create')->action([CollectionController::class, 'create'])->name('collection/create'),
            Route::methods(['GET', 'POST'], '/collection/update/{id:\d+}')->action([CollectionController::class, 'update'])->name('collection/update'),
            Route::post('/collection/delete/{id:\d+}')->action([CollectionController::class, 'delete'])->name('collection/delete'),

            // Format routes (using composite keys)
            Route::get('/format')->action([FormatController::class, 'index'])->name('format/index'),
            Route::get('/format/view/{type}/{name}/{ownedById:\d+}')->action([FormatController::class, 'view'])->name('format/view'),
            Route::methods(['GET', 'POST'], '/format/create')->action([FormatController::class, 'create'])->name('format/create'),
            Route::methods(['GET', 'POST'], '/format/update/{type}/{name}/{ownedById:\d+}')->action([FormatController::class, 'update'])->name('format/update'),
            Route::post('/format/delete/{type}/{name}/{ownedById:\d+}')->action([FormatController::class, 'delete'])->name('format/delete'),

            // Genre routes
            Route::get('/genre')->action([GenreController::class, 'index'])->name('genre/index'),
            Route::get('/genre/view/{id:\d+}')->action([GenreController::class, 'view'])->name('genre/view'),
            Route::methods(['GET', 'POST'], '/genre/create')->action([GenreController::class, 'create'])->name('genre/create'),
            Route::methods(['GET', 'POST'], '/genre/update/{id:\d+}')->action([GenreController::class, 'update'])->name('genre/update'),
            Route::post('/genre/delete/{id:\d+}')->action([GenreController::class, 'delete'])->name('genre/delete'),

            // Item routes
            Route::get('/item')->action([ItemController::class, 'index'])->name('item/index'),
            Route::get('/item/books')->action([ItemController::class, 'books'])->name('item/books'),
            Route::get('/item/ebooks')->action([ItemController::class, 'ebooks'])->name('item/ebooks'),
            Route::get('/item/audiobooks')->action([ItemController::class, 'audiobooks'])->name('item/audiobooks'),
            Route::get('/item/view/{id:\d+}')->action([ItemController::class, 'view'])->name('item/view'),
            Route::methods(['GET', 'POST'], '/item/create')->action([ItemController::class, 'create'])->name('item/create'),
            Route::methods(['GET', 'POST'], '/item/update/{id:\d+}')->action([ItemController::class, 'update'])->name('item/update'),
            Route::post('/item/delete/{id:\d+}')->action([ItemController::class, 'delete'])->name('item/delete'),
            Route::get('/item/search')->action([ItemController::class, 'search'])->name('item/search'),

            // Publisher routes
            Route::get('/publisher')->action([PublisherController::class, 'index'])->name('publisher/index'),
            Route::get('/publisher/view/{id:\d+}')->action([PublisherController::class, 'view'])->name('publisher/view'),
            Route::methods(['GET', 'POST'], '/publisher/create')->action([PublisherController::class, 'create'])->name('publisher/create'),
            Route::methods(['GET', 'POST'], '/publisher/update/{id:\d+}')->action([PublisherController::class, 'update'])->name('publisher/update'),
            Route::post('/publisher/delete/{id:\d+}')->action([PublisherController::class, 'delete'])->name('publisher/delete'),

            // Series routes
            Route::get('/series')->action([SeriesController::class, 'index'])->name('series/index'),
            Route::get('/series/view/{id:\d+}')->action([SeriesController::class, 'view'])->name('series/view'),
            Route::methods(['GET', 'POST'], '/series/create')->action([SeriesController::class, 'create'])->name('series/create'),
            Route::methods(['GET', 'POST'], '/series/update/{id:\d+}')->action([SeriesController::class, 'update'])->name('series/update'),
            Route::post('/series/delete/{id:\d+}')->action([SeriesController::class, 'delete'])->name('series/delete'),
        ),
];
