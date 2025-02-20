<?php

/*
 * Accounts.php
 *
 * Small book management software.
 * Copyright (C) 2016 Sérgio Lopes (knitter.is@gmail.com)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * (c) 2016 Sérgio Lopes
 */

namespace App\Filter;

use App\Model\Account;
use yii\base\Model;
use yii\data\ActiveDataProvider;

//-

/**
 * @license       http://www.gnu.org/licenses/agpl-3.0.txt AGPL
 * @copyright (c) 2016, Sérgio Lopes (knitter.is@gmail.com)
 */
final class Users extends Model {

    public ?string $name = null;
    public ?string $email = null;
    public ?string $login = null;
    public ?string $active = null;

    /**
     * @inheritdoc
     */
    public function rules(): array {
        return [
            [['name', 'email', 'login', 'active'], 'string']
        ];
    }

    /**
     * @param array $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider {
        $query = Account::find()
            ->orderBy(['name' => SORT_ASC]);

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 35],
            'sort' => false
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $provider;
        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'login', $this->login]);

        if (!empty($this->active)) {
            $query->andWhere(['active' => $this->active == 'yes']);
        }

        return $provider;
    }

}
