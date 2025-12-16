<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

use yii\db\Migration;

final class m250619_224155_create_format_table extends Migration {

    public function safeUp(): void {
        $this->createTable('{{%format}}', [
            'type' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'ownedById' => $this->integer()->notNull(),
        ]);

        $this->createIndex('ix_format_type', '{{%format}}', ['type']);
        $this->createIndex('ix_format_name', '{{%format}}', ['name']);
        $this->createIndex('ix_format_ownedById', '{{%format}}', ['ownedById']);
    }

    public function safeDown(): void {
        $this->dropTable('{{%format}}');
    }
}
