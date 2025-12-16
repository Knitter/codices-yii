<?php

declare(strict_types=1);

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
    }

    public function down(MigrationBuilder $b): void {
        $b->dropTable('author');
    }
}
