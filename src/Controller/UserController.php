<?php

/*
 * AccountsController.php
 *
 * Small book management software.
 * Copyright (C) 2016 - 2022 Sérgio Lopes (knitter.is@gmail.com)
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
 * (c) 2016 - 2022 Sérgio Lopes
 */

namespace App\Controller;

use App\Component\Controller;
use App\Filter\Users;
use Yii;

final class UserController extends Controller {

    //    //TODO: Restrict access to admin account only
    //
    //    /**
    //     * @return string
    //     */
    //    public function actionIndex(): string {
    //        $filter = new Accounts();
    //        $provider = $filter->search(Yii::$app->request->queryParams);
    //
    //        return $this->render('index', [
    //            'filter' => $filter,
    //            'provider' => $provider
    //        ]);
    //    }
    //
    //    public function actionAdd() {
    //        throw new \Exception('Not implemented yet!');
    //    }
    //
    //    public function actionEdit(int $id) {
    //        throw new \Exception('Not implemented yet!');
    //    }
    //
    //    public function actionDetails(int $id) {
    //        throw new \Exception('Not implemented yet!');
    //    }
    //
    //    public function actionDelete(int $id) {
    //        throw new \Exception('Not implemented yet!');
    //    }
    //
    //    public function actionProfile() {
    //        throw new \Exception('Not implemented yet!');
    //    }

}
