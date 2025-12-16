<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

use yii\db\Migration;

final class m250619_223946_create_account_table extends Migration {

    public function safeUp(): void {
        $this->createTable('{{%account}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'active' => $this->boolean()->notNull()->defaultValue(true),
            'password' => $this->string()->notNull(),
            'createdOn' => $this->integer()->notNull(),
            'updatedOn' => $this->integer()->notNull(),
            'authKey' => $this->string(),
        ]);

        $this->createIndex('ux_account_username', '{{%account}}', ['username'], true);
        $this->createIndex('ix_account_email', '{{%account}}', ['email'], false);
    }

    public function safeDown(): void {
        $this->dropTable('{{%account}}');
    }
}
