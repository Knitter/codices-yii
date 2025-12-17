<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

use yii\db\Migration;

final class m250619_224032_create_author_table extends Migration {

    public function safeUp(): void {
        $this->createTable('{{%author}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'ownedById' => $this->integer()->notNull(),
            'surname' => $this->string(),
            'biography' => $this->text(),
            'website' => $this->string(),
            'photo' => $this->string(),
        ]);

        $this->createIndex('ix_author_name', '{{%author}}', ['name']);
        $this->createIndex('ix_author_ownedbyid', '{{%author}}', ['ownedById']);
    }

    public function safeDown(): void {
        $this->dropTable('{{%author}}');
    }
}
