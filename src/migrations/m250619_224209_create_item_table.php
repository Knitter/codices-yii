<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

use yii\db\Migration;

final class m250619_224209_create_item_table extends Migration {

    public function safeUp(): void {
        $this->createTable('{{%item}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'ownedById' => $this->integer()->notNull(),
            'type' => $this->string()->notNull(), // "ebook", "audio", "paper"
            'translated' => $this->boolean()->notNull()->defaultValue(false),
            'read' => $this->boolean()->notNull()->defaultValue(false),
            'copies' => $this->integer()->notNull()->defaultValue(1),
            'subtitle' => $this->string(),
            'originalTitle' => $this->string(),
            'plot' => $this->text(),
            'isbn' => $this->string(),
            'format' => $this->string(),
            'pageCount' => $this->integer(),
            'publishDate' => $this->date(),
            'publishYear' => $this->integer(),
            'addedOn' => $this->date(),
            'language' => $this->string(),
            'edition' => $this->string(),
            'volume' => $this->string(),
            'rating' => $this->integer(),
            'url' => $this->string(),
            'review' => $this->text(),
            'cover' => $this->string(),
            'filename' => $this->string(),
            'fileLocation' => $this->string(),
            'narrator' => $this->string(),
            'bitrate' => $this->string(),
            'boughtFrom' => $this->string(),
            'duration' => $this->integer(), // in minutes
            'sizeBytes' => $this->integer(), // in KB
            'orderInSeries' => $this->integer(),
            'publisherId' => $this->integer(),
            'seriesId' => $this->integer(),
            'collectionId' => $this->integer(),
            'duplicatesId' => $this->integer(),
        ]);

        // Indexes
        $this->createIndex('ix_item_title', '{{%item}}', ['title']);
        $this->createIndex('ix_item_ownedbyid', '{{%item}}', ['ownedById']);
        $this->createIndex('ix_item_publisherid', '{{%item}}', ['publisherId']);
        $this->createIndex('ix_item_seriesid', '{{%item}}', ['seriesId']);
        $this->createIndex('ix_item_collectionid', '{{%item}}', ['collectionId']);
        $this->createIndex('ix_item_duplicatesid', '{{%item}}', ['duplicatesId']);
    }

    public function safeDown(): void {
        $this->dropTable('{{%item}}');
    }
}
