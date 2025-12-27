<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\View\Facade;

use Codices\Model\Author;
use yii\base\Model;

final class AuthorForm extends Model {

    public ?int $id = null;
    public ?int $ownedById = null;
    public string $name = '';
    public string $surname = '';
    public string $biography = '';
    public string $website = '';
    public string $photo = '';

    public function rules(): array {
        return [
            [['name', 'authorId'], 'required'],
            [['name', 'photo'], 'string', 'max' => 255],
            [['authorId'], 'integer'],
            [['biography'], 'string'],
            [['website'], 'url'],
        ];
    }

    public function attributeLabels(): array {
        return \Codices\View\Helper\Author::attributeLabels();
    }

    public function loadFromAuthor(Author $author): void {
        $this->id = (int)$author->id;
        $this->ownedById = (int)$author->ownedById;
        $this->name = (string)$author->name;
        $this->surname = (string)$author->surname;
        $this->biography = (string)$author->biography;
        $this->website = (string)$author->website;
        $this->photo = (string)$author->photo;
    }

    public function applyToAuthor(Author $author): Author {
        $author->id = $this->id;
        $author->ownedById = $this->ownedById;
        $author->name = $this->name;
        $author->surname = $this->surname;
        $author->biography = $this->biography;
        $author->website = $this->website;
        $author->photo = $this->photo;

        return $author;
    }
}
