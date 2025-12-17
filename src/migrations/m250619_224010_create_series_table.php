<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

use yii\db\Migration;

final class m250619_224010_create_series_table extends Migration {

    public function safeUp(): void {
        $this->createTable('{{%series}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'ownedById' => $this->integer()->notNull(),
            'completed' => $this->boolean()->notNull()->defaultValue(false),
            'bookCount' => $this->integer(),
            'ownedCount' => $this->integer(),
        ]);

        $this->createIndex('ix_series_name', '{{%series}}', ['name']);
        $this->createIndex('ix_series_ownedbyid', '{{%series}}', ['ownedById']);
    }

    public function safeDown(): void {
        $this->dropTable('{{%series}}');
    }
}
