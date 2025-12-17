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
    public string $name = '';

    public function rules(): array {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels(): array {
        return [
            'name' => 'Name',
        ];
    }

    public function loadFromAuthor(Author $author): void {
        $this->id = (int)$author->id;
        $this->name = (string)$author->name;
    }

    public function applyToAuthor(Author $author): Author {
        $author->name = $this->name;
        return $author;
    }
}
