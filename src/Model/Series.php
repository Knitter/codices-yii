<?php

/*
 * Series.php
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

namespace App\Model;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int                    $id         PK, record ID, auto-increment
 * @property string                 $name       Series' name
 * @property int                    $ownedById  FK, user account the record belongs to
 * @property int                    $finished   Flag, marks the series as having all books written/completed
 * @property int                    $bookCount  Total number of books that were written as part of this series
 * @property int                    $ownedCount Number of books the user owns
 *
 * @property \App\Model\Account $owner      User account that owns this record, relationship
 * @property \App\Model\Book[]  $books      List of books that belong to this series, relationship
 *
 * @license       http://www.gnu.org/licenses/agpl-3.0.txt AGPL
 * @copyright (c) 2016 - 2022, Sérgio Lopes (knitter.is@gmail.com)
 */
final class Series extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName(): string {
        return '{{Series}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array {
        return [
            'name' => Yii::t('codices', 'Name'),
            'finished' => Yii::t('codices', 'finished'),
            'bookCount' => Yii::t('codices', 'No. of Books'),
            'ownedCount' => Yii::t('codices', 'No. of Owned Books')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner(): ActiveQuery {
        return $this->hasOne(Account::class, ['id' => 'ownedById']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBooks(): ActiveQuery {
        return $this->hasMany(Book::class, ['seriesId' => 'id'])
            ->inverseOf('series');
    }
}
