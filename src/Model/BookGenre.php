<?php

/*
 * BookGenre.php
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

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Represents the relationship between a book and the genres that classify it.
 *
 * @property int                  $bookId  Book record ID
 * @property int                  $genreId Genre record ID
 *
 * @property \App\Model\Book  $book
 * @property \App\Model\Genre $genre
 *
 * @license       http://www.gnu.org/licenses/agpl-3.0.txt AGPL
 * @copyright (c) 2016 - 2022, Sérgio Lopes (knitter.is@gmail.com)
 */
final class BookGenre extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName(): string {
        return '{{BookGenre}';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBook(): ActiveQuery {
        return $this->hasOne(Book::class, ['id' => 'bookId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenre(): ActiveQuery {
        return $this->hasOne(Genre::class, ['id' => 'genreId']);
    }
}
