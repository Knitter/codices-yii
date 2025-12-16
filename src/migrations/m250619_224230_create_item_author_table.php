<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

use yii\db\Migration;

final class m250619_224230_create_item_author_table extends Migration {

    public function safeUp(): void {
        $this->createTable('{{%item_author}}', [
            'itemId' => $this->integer()->notNull(),
            'authorId' => $this->integer()->notNull(),
        ]);

        $this->createIndex('ix_item_author_itemId', '{{%item_author}}', ['itemId']);
        $this->createIndex('ix_item_author_authorId', '{{%item_author}}', ['authorId']);
    }

    public function safeDown(): void {
        $this->dropTable('{{%item_author}}');
    }
}
