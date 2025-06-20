<?php

declare(strict_types=1);

namespace App\Migration;

use Yiisoft\Db\Migration\MigrationBuilder;
use Yiisoft\Db\Migration\RevertibleMigrationInterface;
use Yiisoft\Db\Schema\Column\ColumnBuilder;

final class M250619224032Author implements RevertibleMigrationInterface {

    public function up(MigrationBuilder $b): void {
        $b->createTable('author', [
            'id' => ColumnBuilder::primaryKey(),
            'name' => ColumnBuilder::string()->notNull(),
            'ownedById' => ColumnBuilder::integer()->notNull(),
            'surname' => ColumnBuilder::string(),
            'biography' => ColumnBuilder::text(),
            'website' => ColumnBuilder::string(),
            'photo' => ColumnBuilder::string(),
        ]);

        $b->addForeignKey('fk-author-ownedById', 'author', 'ownedById', 'account', 'id');
    }

    public function down(MigrationBuilder $b): void {
        $b->dropForeignKey('fk-author-ownedById', 'author');
        $b->dropTable('author');
    }
}
