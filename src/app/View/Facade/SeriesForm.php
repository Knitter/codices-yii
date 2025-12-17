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

    public function loadFromSeries(Series $series): void {
        $this->id = (int)$series->id;
        $this->name = (string)$series->name;
    }

    public function applyToSeries(Series $series): Series {
        $series->name = $this->name;
        return $series;
    }
}
