<?php

declare(strict_types=1);

namespace App\Migration;

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

        $b->addForeignKey('fk-publisher-ownedById', 'publisher', 'ownedById', 'account', 'id');
    }

    public function down(MigrationBuilder $b): void {
        $b->dropForeignKey('fk-publisher-ownedById', 'publisher');
        $b->dropTable('publisher');
    }
}
