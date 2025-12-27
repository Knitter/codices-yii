<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\View\Model;

use Codices\Query\FormatFilter;
use Codices\Service\FormatService;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\data\DataProviderInterface;

/**
 * FormatSearch represents the model behind the search form of `Codices\Model\Format`.
 */
final class FormatSearch extends Model {
    public ?string $name = null;
    public ?string $type = null;

    /**
     * @return array<array-key, mixed>
     */
    public function rules(): array {
        return [
            [['name', 'type'], 'safe'],
        ];
    }

    /**
     * Creates data provider instance with a search query applied
     *
     * @param FormatService $service
     * @param array<string, mixed> $params
     * @return DataProviderInterface
     */
    public function search(FormatService $service, array $params): DataProviderInterface {
        if (!$this->load($params)) {
            //TODO: Return sensible default
        }

        $filter = FormatFilter::fromArray($params);

        // If attributes are provided via the search model (GridView filter), use them
        if (($this->name !== null && $this->name !== '') || ($this->type !== null && $this->type !== '')) {
            $filter = new FormatFilter(
                type: ($this->type !== null && $this->type !== '') ? $this->type : $filter->type,
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
                    'type' => [
                        'asc' => ['type' => SORT_ASC],
                        'desc' => ['type' => SORT_DESC],
                        'label' => 'Type',
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
