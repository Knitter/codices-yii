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
use yii\data\DataProviderInterface;

/**
 * AccountSearch represents the model behind the search form of `Codices\Model\Account`.
 */
final class AccountSearch extends Model {

    public ?string $id = null;
    public ?string $username = null;
    public ?string $email = null;
    public ?string $name = null;
    public ?string $active = null;

    /**
     * @return array<array-key, mixed>
     */
    public function rules(): array {
        return [
            [['id'], 'integer'],
            [['username', 'email', 'name', 'active'], 'string'],
        ];
    }

    public function attributeLabels(): array {
        return \Codices\View\Helper\Account::attributeLabels();
    }

    /**
     * Creates data provider instance with a search query applied
     *
     * @param AccountService $service
     * @param array<string, mixed> $params
     * @return DataProviderInterface
     */
    public function search(AccountService $service, array $params): DataProviderInterface {
        if (!$this->load($params)) {
            //TODO: Return sensible default
        }

        $filter = new AccountFilter(
            username: $this->username,
            email: $this->email,
            name: $this->name,
            active: $this->active,
            //sort: $filter->sort,
            //direction: $filter->direction,
            //page: $filter->page,
            //pageSize: $filter->pageSize,
            id: !empty($this->id) ? (int)$this->id : null
        );

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
                        //'label' => 'ID',
                    ],
                    'username' => [
                        'asc' => ['username' => SORT_ASC],
                        'desc' => ['username' => SORT_DESC],
                        //'label' => 'Username',
                    ],
                    'email' => [
                        'asc' => ['email' => SORT_ASC],
                        'desc' => ['email' => SORT_DESC],
                        'label' => 'Email',
                    ],
                    'name' => [
                        'asc' => ['name' => SORT_ASC],
                        'desc' => ['name' => SORT_DESC],
                        //'label' => 'Name',
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
