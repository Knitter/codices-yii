<?php

declare(strict_types=1);

final class M250619224237ItemGenre implements RevertibleMigrationInterface {
    public function up(MigrationBuilder $b): void {
        $b->createTable('item_genre', [
            'itemId' => ColumnBuilder::integer()->notNull(),
            'genreId' => ColumnBuilder::integer()->notNull(),
            'PRIMARY KEY (`itemId`, `genreId`)'
        ]);
    }

    public function down(MigrationBuilder $b): void {
        $b->dropTable('item_genre');
    }
}
