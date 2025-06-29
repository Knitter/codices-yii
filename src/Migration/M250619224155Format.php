<?php

declare(strict_types=1);

namespace App\Migration;

use Yiisoft\Db\Migration\MigrationBuilder;
use Yiisoft\Db\Migration\RevertibleMigrationInterface;
use Yiisoft\Db\Schema\Column\ColumnBuilder;

final class M250619224155Format implements RevertibleMigrationInterface {

    public function up(MigrationBuilder $b): void {
        $b->createTable('format', [
            'type' => ColumnBuilder::string()->notNull(),
            'name' => ColumnBuilder::string()->notNull(),
            'ownedById' => ColumnBuilder::integer()->notNull(),
        ]);

        $b->addPrimaryKey('pk-format', 'format', ['type', 'name', 'ownedById']);
    }

    public function down(MigrationBuilder $b): void {
        $b->dropPrimaryKey('pk-format', 'format');
        $b->dropTable('format');
    }
}
