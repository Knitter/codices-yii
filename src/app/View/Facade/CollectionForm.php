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

    public function loadFromCollection(Collection $collection): void {
        $this->id = (int)$collection->id;
        $this->name = (string)$collection->name;
    }

    public function applyToCollection(Collection $collection): Collection {
        $collection->name = $this->name;
        return $collection;
    }
}
