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
            'PRIMARY KEY (`itemId`, `authorId`)'
        ]);
    }

    public function down(MigrationBuilder $b): void {
        $b->dropTable('item_author');
    }
}
