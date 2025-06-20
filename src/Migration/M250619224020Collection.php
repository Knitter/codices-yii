<?php

declare(strict_types=1);

namespace App\Migration;

use Yiisoft\Db\Migration\MigrationBuilder;
use Yiisoft\Db\Migration\RevertibleMigrationInterface;
use Yiisoft\Db\Schema\Column\ColumnBuilder;

final class M250619224020Collection implements RevertibleMigrationInterface {

    public function up(MigrationBuilder $b): void {
        $b->createTable('collection', [
            'id' => ColumnBuilder::primaryKey(),
            'name' => ColumnBuilder::string()->notNull(),
            'ownedById' => ColumnBuilder::integer()->notNull(),
            'publishDate' => ColumnBuilder::date(),
            'publishYear' => ColumnBuilder::integer(),
            'description' => ColumnBuilder::text(),
        ]);

        $b->addForeignKey('fk-collection-ownedById', 'collection', 'ownedById', 'account', 'id');
    }

    public function down(MigrationBuilder $b): void {
        $b->dropForeignKey('fk-collection-ownedById', 'collection');
        $b->dropTable('collection');
    }
}
