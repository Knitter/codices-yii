<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

use yii\db\Migration;

final class m250619_224001_create_publisher_table extends Migration {

    public function safeUp(): void {
        $this->createTable('{{%publisher}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'ownedById' => $this->integer()->notNull(),
            'summary' => $this->text(),
            'website' => $this->string(),
        ]);

        $this->createIndex('ix_publisher_name', '{{%publisher}}', ['name']);
        $this->createIndex('ix_publisher_ownedById', '{{%publisher}}', ['ownedById']);
    }

    public function safeDown(): void {
        $this->dropTable('{{%publisher}}');
    }
}
