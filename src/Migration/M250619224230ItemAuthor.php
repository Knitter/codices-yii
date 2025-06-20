<?php

declare(strict_types=1);

namespace App\Migration;

use Yiisoft\Db\Migration\MigrationBuilder;
use Yiisoft\Db\Migration\RevertibleMigrationInterface;
use Yiisoft\Db\Schema\Column\ColumnBuilder;

final class M250619224230ItemAuthor implements RevertibleMigrationInterface {

    public function up(MigrationBuilder $b): void {
        $b->createTable('item_author', [
            'itemId' => ColumnBuilder::integer()->notNull(),
            'authorId' => ColumnBuilder::integer()->notNull(),
        ]);
        $b->addPrimaryKey('pk-item_author', 'item_author', ['itemId', 'authorId']);

        $b->addForeignKey('fk-item_author-itemId', 'item_author', 'itemId', 'item', 'id');
        $b->addForeignKey('fk-item_author-authorId', 'item_author', 'authorId', 'author', 'id');
    }

    public function down(MigrationBuilder $b): void {
        $b->dropForeignKey('fk-item_author-itemId', 'item_author');
        $b->dropForeignKey('fk-item_author-authorId', 'item_author');
        $b->dropPrimaryKey('pk-item_author', 'item_author');
        $b->dropTable('item_author');
    }
}
