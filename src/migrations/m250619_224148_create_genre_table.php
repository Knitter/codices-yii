<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

use yii\db\Migration;

final class m250619_224148_create_genre_table extends Migration {

    public function safeUp(): void {
        $this->createTable('{{%genre}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'ownedById' => $this->integer()->notNull(),
        ]);

        $this->createIndex('ix_genre_name', '{{%genre}}', ['name']);
        $this->createIndex('ix_genre_ownedbyid', '{{%genre}}', ['ownedById']);
    }

    public function safeDown(): void {
        $this->dropTable('{{%genre}}');
    }
}
