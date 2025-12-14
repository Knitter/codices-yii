<?php

declare(strict_types=1);

namespace Migration;

use Yiisoft\Db\Migration\MigrationBuilder;
use Yiisoft\Db\Migration\RevertibleMigrationInterface;
use Yiisoft\Db\Schema\Column\ColumnBuilder;

/**
 * @since 2025.1
 */
final class M250619223946Account implements RevertibleMigrationInterface {

    public function up(MigrationBuilder $b): void {
        $b->createTable('account', [
            'id' => ColumnBuilder::primaryKey(),
            'username' => ColumnBuilder::string()->notNull()->unique(),
            'email' => ColumnBuilder::string()->notNull(),
            'name' => ColumnBuilder::string()->notNull(),
            'active' => ColumnBuilder::boolean()->notNull()->defaultValue(true),
            'password' => ColumnBuilder::string()->notNull(),
            'createdOn' => ColumnBuilder::integer()->notNull(),
            'updatedOn' => ColumnBuilder::integer()->notNull(),
            'authKey' => ColumnBuilder::string(),
        ]);
    }

    public function down(MigrationBuilder $b): void {
        $b->dropTable('account');
    }
}
