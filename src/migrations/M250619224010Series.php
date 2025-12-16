<?php

declare(strict_types=1);

final class M250619224010Series implements RevertibleMigrationInterface {

    public function up(MigrationBuilder $b): void {

        $b->createTable('series', [
            'id' => ColumnBuilder::primaryKey(),
            'name' => ColumnBuilder::string()->notNull(),
            'ownedById' => ColumnBuilder::integer()->notNull(),
            'completed' => ColumnBuilder::boolean()->notNull()->defaultValue(false),
            'bookCount' => ColumnBuilder::integer(),
            'ownedCount' => ColumnBuilder::integer(),
        ]);
    }

    public function down(MigrationBuilder $b): void {
        $b->dropTable('series');
    }
}
