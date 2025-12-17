<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\View\Facade;

use Codices\Model\Collection;
use yii\base\Model;

final class CollectionForm extends Model {

    public ?int $id = null;
    public ?int $ownedById = null;
    public string $name = '';
    public string $publishDate = '';
    public string $publishYear = '';
    public string $description = '';

    public function rules(): array {
        return [
            [['name', 'ownedById'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['publishDate', 'description'], 'string'],
            [['publishYear'], 'integer'],
        ];
    }

    public function attributeLabels(): array {
        //TODO: Extract to UI/templating layer and avoid the hard dependency on Yii
        return [
            'id' => 'No.',
            'ownedById' => 'Owned By',
            'name' => 'Name',
            'publishDate' => 'Publish Date',
            'publishYear' => 'Publish Year',
            'description' => 'Description',
        ];
    }

    public function loadFromCollection(Collection $collection): void {
        $this->id = (int)$collection->id;
        $this->ownedById = (int)$collection->ownedById;
        $this->publishDate = (string)$collection->publishDate;
        $this->publishYear = (string)$collection->publishYear;
        $this->description = (string)$collection->description;
    }

    public function applyToCollection(Collection $collection): Collection {
        $collection->id = $this->id;
        $collection->ownedById = $this->ownedById;
        $collection->name = $this->name;
        $collection->publishDate = $this->publishDate;
        $collection->publishYear = $this->publishYear;
        $collection->description = $this->description;

        return $collection;
    }
}
