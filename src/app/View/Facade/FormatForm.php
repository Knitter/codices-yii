<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\View\Facade;

use Codices\Model\Format;
use yii\base\Model;

final class FormatForm extends Model {

    public string $type = '';
    public string $name = '';

    public function rules(): array {
        return [
            [['type', 'name'], 'required'],
            [['type', 'name'], 'string', 'max' => 255],
            ['type', 'in', 'range' => array_keys(Format::getFormatTypes())],
        ];
    }

    public function attributeLabels(): array {
        return [
            'type' => 'Type',
            'name' => 'Name',
        ];
    }

    public function loadFromFormat(Format $format): void {
        $this->type = (string)$format->type;
        $this->name = (string)$format->name;
    }

    public function applyToFormat(Format $format): Format {
        $format->type = $this->type;
        $format->name = $this->name;
        return $format;
    }
}
