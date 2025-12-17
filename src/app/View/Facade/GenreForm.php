<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\View\Facade;

use Codices\Model\Genre;
use yii\base\Model;

final class GenreForm extends Model {

    public ?int $id = null;
    public ?int $ownedById = null;
    public string $name = '';

    public function rules(): array {
        return [
            [['name', 'ownedById'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels(): array {
        //TODO: Extract to UI/templating layer and avoid the hard dependency on Yii
        return [
            'id' => 'No.',
            'name' => 'Name',
            'ownedById' => 'Owned By',
        ];
    }

    public function loadFromGenre(Genre $genre): void {
        $this->id = (int)$genre->id;
        $this->ownedById = (int)$genre->ownedById;
        $this->name = (string)$genre->name;
    }

    public function applyToGenre(Genre $genre): Genre {
        $genre->ownedById = $this->ownedById;
        $genre->name = $this->name;
        
        return $genre;
    }
}
