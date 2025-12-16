<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

use yii\db\Migration;

final class m250619_224237_create_item_genre_table extends Migration {

    public function safeUp(): void {
        $this->createTable('{{%item_genre}}', [
            'itemId' => $this->integer()->notNull(),
            'genreId' => $this->integer()->notNull(),
        ]);

        $this->createIndex('ix_item_genre_itemId', '{{%item_genre}}', ['itemId']);
        $this->createIndex('ix_item_genre_genreId', '{{%item_genre}}', ['genreId']);
    }

    public function safeDown(): void {
        $this->dropTable('{{%item_genre}}');
    }
}
