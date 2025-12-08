<?php

declare(strict_types=1);

namespace App\app\Migration;

use Yiisoft\Db\Migration\MigrationBuilder;
use Yiisoft\Db\Migration\RevertibleMigrationInterface;
use Yiisoft\Db\Schema\Column\ColumnBuilder;

final class M250619224001Publisher implements RevertibleMigrationInterface {

    public function up(MigrationBuilder $b): void {
        $b->createTable('publisher', [
            'id' => ColumnBuilder::primaryKey(),
            'name' => ColumnBuilder::string()->notNull(),
            'ownedById' => ColumnBuilder::integer()->notNull(),
            'summary' => ColumnBuilder::text(),
            'website' => ColumnBuilder::string(),
        ]);
    }

    public function down(MigrationBuilder $b): void {
        $b->dropTable('publisher');
    }
}
