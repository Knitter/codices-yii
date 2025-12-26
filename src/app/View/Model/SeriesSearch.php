<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\View\Model;

use Codices\Query\SeriesFilter;
use Codices\Service\SeriesService;
use yii\base\Model;
use yii\data\ArrayDataProvider;

/**
 * SeriesSearch represents the model behind the search form of `Codices\Model\Series`.
 */
final class SeriesSearch extends Model {
    public ?string $name = null;
    public ?string $id = null;

    /**
     * @return array<array-key, mixed>
     */
    public function rules(): array {
        return [
            [['id'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    /**
     * Creates data provider instance with a search query applied
     *
     * @param SeriesService $service
     * @param array<string, mixed> $params
     * @return ArrayDataProvider
     */
    public function search(SeriesService $service, array $params): ArrayDataProvider {
        $this->load($params);
        $filter = SeriesFilter::fromArray($params);

        // If attributes are provided via the search model (GridView filter), use them
        if (($this->name !== null && $this->name !== '') || ($this->id !== null && $this->id !== '')) {
            $filter = new SeriesFilter(
                id: ($this->id !== null && $this->id !== '') ? (int)$this->id : $filter->id,
                name: ($this->name !== null && $this->name !== '') ? $this->name : $filter->name,
                sort: $filter->sort,
                direction: $filter->direction,
                page: $filter->page,
                pageSize: $filter->pageSize
            );
        }

        $result = $service->search($filter);
        return new ArrayDataProvider([
            'allModels' => $result->items,
            'totalCount' => $result->total,
            'pagination' => [
                'pageSize' => $result->pageSize,
                'page' => $result->page - 1,
                'pageParam' => 'page',
                'pageSizeParam' => 'per_page',
            ],
            'sort' => [
                'attributes' => [
                    'name' => [
                        'asc' => ['name' => SORT_ASC],
                        'desc' => ['name' => SORT_DESC],
                        'default' => SORT_ASC,
                        'label' => 'Name',
                    ],
                    'id' => [
                        'asc' => ['id' => SORT_ASC],
                        'desc' => ['id' => SORT_DESC],
                        'label' => 'ID',
                    ],
                ],
                'defaultOrder' => [
                    $filter->sort => $filter->direction === 'desc' ? SORT_DESC : SORT_ASC,
                ],
                'sortParam' => 'sort',
            ],
        ]);
    }
}
