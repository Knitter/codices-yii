<?php

declare(strict_types=1);

namespace Codices\Controller;

use Codices\Model\Author;
use Codices\Model\Collection;
use Codices\Model\Format;
use Codices\Model\Genre;
use Codices\Model\Item;
use Codices\Model\ItemAuthor;
use Codices\Model\ItemGenre;
use Codices\Model\Publisher;
use Codices\Model\Series;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Yiisoft\ActiveRecord\ActiveQuery;
use Yiisoft\Data\Db\QueryDataReader;
use Yiisoft\Data\Paginator\OffsetPaginator;
use Yiisoft\Data\Reader\Filter\All;
use Yiisoft\Data\Reader\Filter\Equals;
use Yiisoft\Data\Reader\Filter\GreaterThanOrEqual;
use Yiisoft\Data\Reader\Filter\LessThanOrEqual;
use Yiisoft\Data\Reader\Filter\Like;
use Yiisoft\Data\Reader\Sort;
use Yiisoft\Http\Method;
use Yiisoft\Router\CurrentRoute;
use Yiisoft\Validator\ValidatorInterface;
use Yiisoft\Yii\View\Renderer\ViewRenderer;

final class BookController {

    public function __construct(private ViewRenderer                    $viewRenderer,
                                private readonly ServerRequestInterface $request,
                                private readonly ResponseInterface      $response) {

        $this->viewRenderer = $viewRenderer->withControllerName('book');
    }

    public function index(CurrentRoute $currentRoute): ResponseInterface {
        //TODO: Move filters to BookFilter class as soon as I understand the all Yii3 structure, packages, etc..
        $queryParams = $this->request->getQueryParams();
        $query = new ActiveQuery(Item::class)->where(['type' => Item::TYPE_PAPER]);

        $filters = [];
        if (!empty($queryParams['title'])) {
            $filters[] = new Like('title', $queryParams['title']);
        }

        if (!empty($queryParams['author'])) {
            $query = $query->joinWith('authors');
            $filters[] = new Like('author.name', $queryParams['author']);
        }

        if (!empty($queryParams['genre_id'])) {
            $query = $query->joinWith('genres');
            $filters[] = new Equals('genre.id', (int)$queryParams['genre_id']);
        }

        if (!empty($queryParams['publisher_id'])) {
            $filters[] = new Equals('publisherId', (int)$queryParams['publisher_id']);
        }

        if (!empty($queryParams['year_from'])) {
            $filters[] = new GreaterThanOrEqual('publishYear', (int)$queryParams['year_from']);
        }

        if (!empty($queryParams['year_to'])) {
            $filters[] = new LessThanOrEqual('publishYear', (int)$queryParams['year_to']);
        }

        if (!empty($queryParams['rating'])) {
            $filters[] = new Equals('rating', (int)$queryParams['rating']);
        }

        $dataReader = new QueryDataReader($query);
        if (!empty($filters)) {
            $dataReader = $dataReader->withFilter(new All(...$filters));
        }

        $sort = Sort::only([
            'title' => [
                'asc' => ['title' => SORT_ASC],
                'desc' => ['title' => SORT_DESC],
            ],
            'publishYear' => [
                'asc' => ['publishYear' => SORT_ASC],
                'desc' => ['publishYear' => SORT_DESC],
            ],
            'rating' => [
                'asc' => ['rating' => SORT_ASC],
                'desc' => ['rating' => SORT_DESC],
            ],
            'addedOn' => [
                'asc' => ['addedOn' => SORT_ASC],
                'desc' => ['addedOn' => SORT_DESC],
            ],
        ]);

        $sortOrder = $queryParams['sort'] ?? 'title';
        $sortDirection = $queryParams['sort_dir'] ?? 'asc';
        //$dataReader = $dataReader->withSort($sort->withOrder([$sortOrder => $sortDirection === 'desc' ? SORT_DESC : SORT_ASC]));

        $paginator = new OffsetPaginator($dataReader);
        $paginator = $paginator->withPageSize((int)($queryParams['per_page'] ?? 20));
        $paginator = $paginator->withCurrentPage((int)($queryParams['page'] ?? 1));

        //TODO: Fix this... Yii2 was so much simpler :(
        $genres = [];//Genre::find()->orderBy('name')->all();
        $publishers = [];//Publisher::find()->orderBy('name')->all();

        return $this->viewRenderer->render('index', [
            'paginator' => $paginator,
            'queryParams' => $queryParams,
            //'genres' => $genres,
            //'publishers' => $publishers,
            'sort' => $sort,
            'currentSort' => $sortOrder,
            'currentDirection' => $sortDirection,
        ]);
    }

    public function add(ValidatorInterface $validator): ResponseInterface {
        //TODO: Move filters to BookForm class as soon as I understand the all Yii3 structure, packages, etc..
        $item = new Item();
        //TODO: use public property approach since we consider AR models to be simple DB-to-APP connectors/DTO and all
        //logic should go into form models, filter models and possible repositories.
        $item->type = Item::TYPE_PAPER;

        if ($this->request->getMethod() === Method::POST) {
            $body = $this->request->getParsedBody();

            // Set basic attributes
            $item->title = $body['title'] ?? '';
            $item->subtitle = $body['subtitle'] ?? null;
            $item->originalTitle = $body['originalTitle'] ?? null;
            $item->plot = $body['plot'] ?? null;
            $item->isbn = $body['isbn'] ?? null;
            $item->format = $body['format'] ?? null;
            $item->pageCount = !empty($body['pageCount']) ? (int)$body['pageCount'] : null;
            $item->publishDate = $body['publishDate'] ?? null;
            $item->publishYear = !empty($body['publishYear']) ? (int)$body['publishYear'] : null;
            $item->language = $body['language'] ?? null;
            $item->edition = $body['edition'] ?? null;
            $item->volume = $body['volume'] ?? null;
            $item->rating = !empty($body['rating']) ? (int)$body['rating'] : null;
            $item->url = $body['url'] ?? null;
            $item->review = $body['review'] ?? null;
            $item->publisherId = !empty($body['publisherId']) ? (int)$body['publisherId'] : null;
            $item->seriesId = !empty($body['seriesId']) ? (int)$body['seriesId'] : null;
            $item->collectionId = !empty($body['collectionId']) ? (int)$body['collectionId'] : null;
            $item->orderInSeries = !empty($body['orderInSeries']) ? (int)$body['orderInSeries'] : null;
            $item->copies = !empty($body['copies']) ? (int)$body['copies'] : 1;
            $item->translated = !empty($body['translated']);
            $item->read = !empty($body['read']);

            // Set owner (you might want to get this from session/auth)
            $item->ownedById = 1; // TODO: Get from authenticated user

            $result = $validator->validate($item);
            if ($result->isValid() && $item->save()) {
                // Handle authors
                if (!empty($body['authors'])) {
                    $this->saveAuthors($item, $body['authors']);
                }

                // Handle genres
                if (!empty($body['genres'])) {
                    $this->saveGenres($item, $body['genres']);
                }

                // Redirect to index
                return $this->response->withHeader('Location', '/book')->withStatus(302);
            }
        }

        //$authors = Author::find()->orderBy('name')->all();
        //$genres = Genre::find()->orderBy('name')->all();
        //$publishers = Publisher::find()->orderBy('name')->all();
        //$series = Series::find()->orderBy('name')->all();
        //$collections = Collection::find()->orderBy('name')->all();
        //$formats = Format::find()->orderBy('name')->all();
        return $this->viewRenderer->render('add', [
            'item' => $item,
//            'authors' => $authors,
//            'genres' => $genres,
//            'publishers' => $publishers,
//            'series' => $series,
//            'collections' => $collections,
//            'formats' => $formats,
        ]);
    }

    public function edit(CurrentRoute $currentRoute, ValidatorInterface $validator): ResponseInterface {
        //TODO: Move filters to BookForm class as soon as I understand the all Yii3 structure, packages, etc..
        $id = (int)$currentRoute->getArgument('id');
        $item = Item::findOne(['id' => $id, 'type' => Item::TYPE_PAPER]);

        if ($item === null) {
            return $this->response->withStatus(404);
        }

        if ($this->request->getMethod() === Method::POST) {
            $body = $this->request->getParsedBody();

            // Update attributes
            $item->title = $body['title'] ?? '';
            $item->subtitle = $body['subtitle'] ?? null;
            $item->originalTitle = $body['originalTitle'] ?? null;
            $item->plot = $body['plot'] ?? null;
            $item->isbn = $body['isbn'] ?? null;
            $item->format = $body['format'] ?? null;
            $item->pageCount = !empty($body['pageCount']) ? (int)$body['pageCount'] : null;
            $item->publishDate = $body['publishDate'] ?? null;
            $item->publishYear = !empty($body['publishYear']) ? (int)$body['publishYear'] : null;
            $item->language = $body['language'] ?? null;
            $item->edition = $body['edition'] ?? null;
            $item->volume = $body['volume'] ?? null;
            $item->rating = !empty($body['rating']) ? (int)$body['rating'] : null;
            $item->url = $body['url'] ?? null;
            $item->review = $body['review'] ?? null;
            $item->publisherId = !empty($body['publisherId']) ? (int)$body['publisherId'] : null;
            $item->seriesId = !empty($body['seriesId']) ? (int)$body['seriesId'] : null;
            $item->collectionId = !empty($body['collectionId']) ? (int)$body['collectionId'] : null;
            $item->orderInSeries = !empty($body['orderInSeries']) ? (int)$body['orderInSeries'] : null;
            $item->copies = !empty($body['copies']) ? (int)$body['copies'] : 1;
            $item->translated = !empty($body['translated']);
            $item->read = !empty($body['read']);

            $result = $validator->validate($item);

            if ($result->isValid() && $item->save()) {
                // Update authors
                if (isset($body['authors'])) {
                    $this->saveAuthors($item, $body['authors']);
                }

                // Update genres
                if (isset($body['genres'])) {
                    $this->saveGenres($item, $body['genres']);
                }

                // Redirect to index
                return $this->response->withHeader('Location', '/book')->withStatus(302);
            }
        }

        // Get form data
        $authors = Author::find()->orderBy('name')->all();
        $genres = Genre::find()->orderBy('name')->all();
        $publishers = Publisher::find()->orderBy('name')->all();
        $series = Series::find()->orderBy('name')->all();
        $collections = Collection::find()->orderBy('name')->all();
        $formats = Format::find()->orderBy('name')->all();

        // Get current authors and genres
        $currentAuthors = $item->getAuthors()->all();
        $currentGenres = $item->getGenres()->all();

        return $this->viewRenderer->render('edit', [
            'item' => $item,
            'authors' => $authors,
            'genres' => $genres,
            'publishers' => $publishers,
            'series' => $series,
            'collections' => $collections,
            'formats' => $formats,
            'currentAuthors' => $currentAuthors,
            'currentGenres' => $currentGenres,
        ]);
    }

    public function delete(CurrentRoute $currentRoute): ResponseInterface {
        $id = (int)$currentRoute->getArgument('id');
        $item = Item::findOne(['id' => $id, 'type' => Item::TYPE_PAPER]);
        if ($item === null) {
            return $this->response->withStatus(404);
        }

        if ($this->request->getMethod() === Method::POST) {
            //ItemAuthor::deleteAll(['itemId' => $item->id]);
            //ItemGenre::deleteAll(['itemId' => $item->id]);

            if ($item->delete()) {
                return $this->response->withHeader('Location', '/book')->withStatus(302);
            }
        }

        return $this->response->withHeader('Location', '/book')->withStatus(302);
    }

    private function saveAuthors(Item $item, array $authorIds): void {
        // Delete existing associations
        ItemAuthor::deleteAll(['itemId' => $item->id]);

        // Create new associations
        foreach ($authorIds as $authorId) {
            if (!empty($authorId)) {
                $itemAuthor = new ItemAuthor();
                $itemAuthor->itemId = $item->id;
                $itemAuthor->authorId = (int)$authorId;
                $itemAuthor->save();
            }
        }
    }

    private function saveGenres(Item $item, array $genreIds): void {
        // Delete existing associations
        ItemGenre::deleteAll(['itemId' => $item->id]);

        // Create new associations
        foreach ($genreIds as $genreId) {
            if (!empty($genreId)) {
                $itemGenre = new ItemGenre();
                $itemGenre->itemId = $item->id;
                $itemGenre->genreId = (int)$genreId;
                $itemGenre->save();
            }
        }
    }
}
