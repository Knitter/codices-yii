<?php

declare(strict_types=1);

namespace App\Migration;

use Yiisoft\Db\Migration\MigrationBuilder;
use Yiisoft\Db\Migration\RevertibleMigrationInterface;
use Yiisoft\Db\Schema\Column\ColumnBuilder;

final class M250619224148Genre implements RevertibleMigrationInterface {

    public function up(MigrationBuilder $b): void {
        $b->createTable('genre', [
            'id' => ColumnBuilder::primaryKey(),
            'name' => ColumnBuilder::string()->notNull(),
            'ownedById' => ColumnBuilder::integer()->notNull(),
        ]);
    }

    public function down(MigrationBuilder $b): void {
        $b->dropTable('genre');
    }
}
