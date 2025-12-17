<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\View\Facade;

use Codices\Model\Publisher;
use yii\base\Model;

final class PublisherForm extends Model {

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

    public function loadFromPublisher(Publisher $publisher): void {
        $this->id = (int)$publisher->id;
        $this->name = (string)$publisher->name;
    }

    public function applyToPublisher(Publisher $publisher): Publisher {
        $publisher->name = $this->name;
        return $publisher;
    }
}
