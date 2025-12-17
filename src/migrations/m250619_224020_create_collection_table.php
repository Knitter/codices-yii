<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

use yii\db\Migration;

final class m250619_224020_create_collection_table extends Migration {

    public function safeUp(): void {
        $this->createTable('{{%collection}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'ownedById' => $this->integer()->notNull(),
            'publishDate' => $this->date(),
            'publishYear' => $this->integer(),
            'description' => $this->text(),
        ]);

        $this->createIndex('ix_collection_name', '{{%collection}}', ['name']);
        $this->createIndex('ix_collection_ownedbyid', '{{%collection}}', ['ownedById']);
    }

    public function safeDown(): void {
        $this->dropTable('{{%collection}}');
    }
}
