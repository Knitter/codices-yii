<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

namespace Codices\View\Helper;

use Yii;

final class Item {

    public static function attributeLabels(): array {
        return [
            'title' => Yii::t('codices', 'Title'),
            'subtitle' => Yii::t('codices', 'Subtitle'),
            'originalTitle' => Yii::t('codices', 'Original Title'),
            'plot' => Yii::t('codices', 'Plot'),
            'isbn' => Yii::t('codices', 'ISBN'),
            'format' => Yii::t('codices', 'Format'),
            'pageCount' => Yii::t('codices', 'Pages'),
            'publishDate' => Yii::t('codices', 'Publish Date'),
            'publishYear' => Yii::t('codices', 'Publish Year'),
            'language' => Yii::t('codices', 'Language'),
            'edition' => Yii::t('codices', 'Edition'),
            'volume' => Yii::t('codices', 'Volume'),
            'rating' => Yii::t('codices', 'Rating'),
            'url' => Yii::t('codices', 'URL'),
            'review' => Yii::t('codices', 'Review'),
            'publisherId' => Yii::t('codices', 'Publisher'),
            'seriesId' => Yii::t('codices', 'Series'),
            'collectionId' => Yii::t('codices', 'Collection'),
            'orderInSeries' => Yii::t('codices', 'Order in Series'),
            'copies' => Yii::t('codices', 'Copies'),
            'translated' => Yii::t('codices', 'Translated'),
            'read' => Yii::t('codices', 'Read'),
            'type' => Yii::t('codices', 'Type'),
            'authors' => Yii::t('codices', 'Authors'),
            'genres' => Yii::t('codices', 'Genres'),
            'cover' => Yii::t('codices', 'Cover'),
            'filename' => Yii::t('codices', 'Filename'),
            'fileLocation' => Yii::t('codices', 'File Location'),
            'narrator' => Yii::t('codices', 'Narrator'),
            'bitrate' => Yii::t('codices', 'Bitrate'),
            'boughtFrom' => Yii::t('codices', 'Bought From'),
            'duration' => Yii::t('codices', 'Duration'),
            'sizeBytes' => Yii::t('codices', 'Size'),
            'duplicatesId' => Yii::t('codices', 'Duplicates')
        ];
    }

    public static function getTypes(): array {
        return [
            \Codices\Model\Item::TYPE_PAPER => Yii::t('codices', 'Paper Book'),
            \Codices\Model\Item::TYPE_EBOOK => Yii::t('codices', 'E-Book'),
            \Codices\Model\Item::TYPE_AUDIO => Yii::t('codices', 'Audiobook')
        ];
    }
}
