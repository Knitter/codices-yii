<?php

declare(strict_types=1);

namespace App\Migration;

use Yiisoft\Db\Migration\MigrationBuilder;
use Yiisoft\Db\Migration\RevertibleMigrationInterface;
use Yiisoft\Db\Schema\Column\ColumnBuilder;

final class M250619224237ItemGenre implements RevertibleMigrationInterface {

    public function up(MigrationBuilder $b): void {

        $b->createTable('item_genre', [
            'itemId' => ColumnBuilder::integer()->notNull(),
            'genreId' => ColumnBuilder::integer()->notNull(),
        ]);

        $b->addPrimaryKey('pk-item_genre', 'item_genre', ['itemId', 'genreId']);
        $b->addForeignKey('fk-item_genre-itemId', 'item_genre', 'itemId', 'item', 'id');
        $b->addForeignKey('fk-item_genre-genreId', 'item_genre', 'genreId', 'genre', 'id');
    }

    public function down(MigrationBuilder $b): void {
        $b->dropForeignKey('fk-item_genre-itemId', 'item_genre');
        $b->dropForeignKey('fk-item_genre-genreId', 'item_genre');
        $b->dropPrimaryKey('pk-item_genre', 'item_genre');
        $b->dropTable('item_genre');
    }
}
