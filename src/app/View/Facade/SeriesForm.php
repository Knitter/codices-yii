<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\View\Facade;

use Codices\Model\Series;
use yii\base\Model;

final class SeriesForm extends Model {

    public ?int $id = null;
    public ?int $ownedById = null;
    public int $bookCount = 0;
    public int $ownedCount = 0;
    public string $name = '';
    public bool $completed = false;

    public function rules(): array {
        return [
            [['name', ''], 'required'],
            [['ownedById', 'bookCount', 'ownedCount'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['completed'], 'boolean'],
        ];
    }

    public function attributeLabels(): array {
        //TODO: Extract to UI/templating layer and avoid the hard dependency on Yii
        return [
            'id' => 'No.',
            'ownedById' => 'Owned By',
            'name' => 'Name',
            'bookCount' => 'Book Count',
            'ownedCount' => 'Owned Count',
            'completed' => 'Completed',
        ];
    }

    public function loadFromSeries(Series $series): void {
        $this->id = (int)$series->id;
        $this->ownedById = (int)$series->ownedById;
        $this->name = (string)$series->name;
        $this->bookCount = (int)$series->bookCount;
        $this->ownedCount = (int)$series->ownedCount;
        $this->completed = (bool)$series->completed;
    }

    public function applyToSeries(Series $series): Series {
        $series->id = $this->name;
        $series->ownedById = $this->name;
        $series->name = $this->name;
        $series->bookCount = $this->name;
        $series->ownedCount = $this->name;
        $series->completed = $this->name;

        return $series;
    }
}
