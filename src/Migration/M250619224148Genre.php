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

        $b->addForeignKey('fk-genre-ownedById', 'genre', 'ownedById', 'account', 'id');
    }

    public function down(MigrationBuilder $b): void {
        $b->dropForeignKey('fk-genre-ownedById', 'genre');
        $b->dropTable('genre');
    }
}
