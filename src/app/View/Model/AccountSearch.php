<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\View\Model;

use Codices\Query\AccountFilter;
use Codices\Service\AccountService;
use yii\base\Model;
use yii\data\ArrayDataProvider;

/**
 * AccountSearch represents the model behind the search form of `Codices\Model\Account`.
 */
final class AccountSearch extends Model {
    public ?string $id = null;
    public ?string $username = null;
    public ?string $email = null;
    public ?string $name = null;

    /**
     * @return array<array-key, mixed>
     */
    public function rules(): array {
        return [
            [['id'], 'integer'],
            [['username', 'email', 'name'], 'safe'],
        ];
    }

    /**
     * Creates data provider instance with a search query applied
     *
     * @param AccountService $service
     * @param array<string, mixed> $params
     * @return ArrayDataProvider
     */
    public function search(AccountService $service, array $params): ArrayDataProvider {
        $this->load($params);
        $filter = AccountFilter::fromArray($params);

        // If attributes are provided via the search model (GridView filter), use them
        if (($this->id !== null && $this->id !== '') ||
            ($this->username !== null && $this->username !== '') ||
            ($this->email !== null && $this->email !== '') ||
            ($this->name !== null && $this->name !== '')) {
            $filter = new AccountFilter(
                username: ($this->username !== null && $this->username !== '') ? $this->username : $filter->username,
                email: ($this->email !== null && $this->email !== '') ? $this->email : $filter->email,
                name: ($this->name !== null && $this->name !== '') ? $this->name : $filter->name,
                active: $filter->active,
                sort: $filter->sort,
                direction: $filter->direction,
                page: $filter->page,
                pageSize: $filter->pageSize,
                id: ($this->id !== null && $this->id !== '') ? (int)$this->id : $filter->id
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
                    'id' => [
                        'asc' => ['id' => SORT_ASC],
                        'desc' => ['id' => SORT_DESC],
                        'label' => 'ID',
                    ],
                    'username' => [
                        'asc' => ['username' => SORT_ASC],
                        'desc' => ['username' => SORT_DESC],
                        'label' => 'Username',
                    ],
                    'email' => [
                        'asc' => ['email' => SORT_ASC],
                        'desc' => ['email' => SORT_DESC],
                        'label' => 'Email',
                    ],
                    'name' => [
                        'asc' => ['name' => SORT_ASC],
                        'desc' => ['name' => SORT_DESC],
                        'label' => 'Name',
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
