<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\View\Model;

use Codices\Service\AccountService;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\Expression;

final class AccountGridFilter extends Model {

    public ?string $username = null;
    public ?string $email = null;
    public ?string $name = null;
    public ?string $active = null;

    public function rules() {
        return [
            [['username', 'email', 'name', 'active'], 'string']
        ];
    }

    public function attributeLabels(): array {
        //TODO: Extract to UI/templating layer and avoid the hard dependency on Yii
        return [
            'id' => Yii::t('codices', 'No.'),
            'username' => Yii::t('codices', 'Username'),
            'email' => Yii::t('codices', 'Email'),
            'name' => Yii::t('codices', 'Name'),
            'active' => Yii::t('codices', 'Active'),
            'password' => Yii::t('codices', 'Password'),
            'confirmPassword' => Yii::t('codices', 'Confirm password'),
        ];
    }

    public function apply(array $params, AccountService $accountService): ArrayDataProvider {
        //$username = self::nullIfEmpty($query['username'] ?? null);
        //        $email = self::nullIfEmpty($query['email'] ?? null);
        //        $name = self::nullIfEmpty($query['name'] ?? null);
        //
        //        $activeParam = $query['active'] ?? null;
        //        $active = null;
        //        if ($activeParam !== null && $activeParam !== '') {
        //            $active = $activeParam === 'yes' ? 1 : ($activeParam === 'no' ? 0 : null);
        //        }
        //
        //        $sort = in_array(($query['sort'] ?? 'username'), ['id', 'username', 'email', 'name'], true)
        //            ? !empty($query['sort']) ? (string)$query['sort'] : 'username'
        //            : 'username';
        //
        //        $direction = strtolower((string)($query['sort_dir'] ?? ($query['direction'] ?? 'asc')));
        //        $direction = $direction === 'desc' ? 'desc' : 'asc';
        //
        //        $page = max(1, (int)($query['page'] ?? 1));
        //        $pageSize = max(1, min(100, (int)($query['per_page'] ?? ($query['pageSize'] ?? 25))));
        //
        //        return new self($username, $email, $name, $active, $sort, $direction, $page, $pageSize);



        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => $pageSize],
            'sort' => [
                'defaultOrder' => [
                    'code' => SORT_ASC
                ],
                'attributes' => [
                    'code' => [
                        'asc' => new Expression("REGEXP_SUBSTR(p.code, '[a-zA-Z]+') ASC, REGEXP_SUBSTR(p.code, '[0-9]+')::INTEGER ASC"),
                        'desc' => new Expression("REGEXP_SUBSTR(p.code, '[a-zA-Z]+') DESC, REGEXP_SUBSTR(p.code, '[0-9]+')::INTEGER DESC"),
                    ],
                    'description',
                    'quantity',
                    'min_quantity',
                    'reference',
                    'brandId' => [
                        'asc' => ['p.brand_name' => SORT_ASC],
                        'desc' => ['p.brand_name' => SORT_DESC],
                    ],
                    'model',
                    'supplierId' => [
                        'asc' => ['p.supplier_name' => SORT_ASC],
                        'desc' => ['p.supplier_name' => SORT_DESC],
                    ],
                    'supplierRef',
                    'barcode',
                    'obsolete',
                ],
            ]
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

//        if (!isset($this->categoryId)) {
//            $this->categoryId = $this->rootId;
//        }
//
//        $category = Category::find()->where(['id' => $this->categoryId])->one();
//        $allSubcategories = $category->getAllSubcategories();
//
//        $query->andWhere(['p.category_id' => $allSubcategories]);
//
//        if ($this->showObsolete !== 'yes') {
//            $query->andWhere('p.obsolete IS FALSE');
//        }

//        if ($this->obsolete === 'yes') {
//            $query->andWhere('p.obsolete IS TRUE');
//        } else if ($this->obsolete === 'no') {
//            $query->andWhere('p.obsolete IS FALSE');
//        }
//
//        if ($this->stockMinQty === 'yes') {
//            $query->andWhere('p.min_quantity <= 0 AND i.quantity > 0');
//        }
//
//        if ($this->rupture === 'yes') {
//            $query->andWhere('COALESCE(p.min_quantity, 0) > 0 AND i.quantity < p.min_quantity');
//        }

        $query->andFilterWhere([
            'p.code' => $this->code,
            'p.brand_id' => $this->brandId,
            'p.model' => $this->model,
            'p.supplier_id' => $this->supplierId,
        ])
            ->andFilterWhere(['ilike', 'p.description', $this->description])
            ->andFilterWhere(['ilike', 'p.barcode', $this->barcode])
            ->andFilterWhere(['ilike', 'p.reference', $this->reference])
            ->andFilterWhere(['ilike', 'p.supplier_reference', $this->supplierRef]);


        return $dataProvider;
        $result = $accountService->search($filter);
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
                        'default' => SORT_ASC,
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
                'sortParam' => 'sort'
            ],
        ]);
    }
}
