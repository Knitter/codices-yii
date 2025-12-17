<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\View\Facade;

use Codices\Model\Publisher;
use Yii;
use yii\base\Model;

final class PublisherForm extends Model {

    public ?int $id = null;
    public ?int $ownedById = null;
    public string $name = '';
    public string $summary = '';
    public string $website = '';

    public function rules(): array {
        return [
            [['name', 'ownedById'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['ownedById'], 'integer'],
            [['summary'], 'string'],
            [['website'], 'url'],
        ];
    }

    public function attributeLabels(): array {
        //TODO: Extract to UI/templating layer and avoid the hard dependency on Yii
        return [
            'id' => Yii::t('codices', 'No.'),
            'ownedById' => Yii::t('codices', 'Name'),
            'summary' => Yii::t('codices', 'Summary'),
            'website' => Yii::t('codices', 'Website'),
        ];
    }

    public function loadFromPublisher(Publisher $publisher): void {
        $this->id = (int)$publisher->id;
        $this->ownedById = (int)$publisher->ownedById;
        $this->name = (string)$publisher->name;
        $this->summary = (string)$publisher->summary;
        $this->website = (string)$publisher->website;
    }

    public function applyToPublisher(Publisher $publisher): Publisher {
        $publisher->id = $this->id;
        $publisher->ownedById = $this->ownedById;
        $publisher->name = $this->name;
        $publisher->summary = $this->summary;
        $publisher->website = $this->website;

        return $publisher;
    }
}
