<?php

declare(strict_types=1);

namespace App\app\Migration;

use Yiisoft\Db\Migration\MigrationBuilder;
use Yiisoft\Db\Migration\RevertibleMigrationInterface;
use Yiisoft\Db\Schema\Column\ColumnBuilder;

final class M250619224209Item implements RevertibleMigrationInterface {
    public function up(MigrationBuilder $b): void {
        $b->createTable('item', [
            'id' => ColumnBuilder::primaryKey(),
            'title' => ColumnBuilder::string()->notNull(),
            'ownedById' => ColumnBuilder::integer()->notNull(),
            'type' => ColumnBuilder::string()->notNull(), // "ebook", "audio", "paper"
            'translated' => ColumnBuilder::boolean()->notNull()->defaultValue(false),
            'read' => ColumnBuilder::boolean()->notNull()->defaultValue(false),
            'copies' => ColumnBuilder::integer()->notNull()->defaultValue(1),
            'subtitle' => ColumnBuilder::string(),
            'originalTitle' => ColumnBuilder::string(),
            'plot' => ColumnBuilder::text(),
            'isbn' => ColumnBuilder::string(),
            'format' => ColumnBuilder::string(),
            'pageCount' => ColumnBuilder::integer(),
            'publishDate' => ColumnBuilder::date(),
            'publishYear' => ColumnBuilder::integer(),
            'addedOn' => ColumnBuilder::date(),
            'language' => ColumnBuilder::string(),
            'edition' => ColumnBuilder::string(),
            'volume' => ColumnBuilder::string(),
            'rating' => ColumnBuilder::integer(),
            'url' => ColumnBuilder::string(),
            'review' => ColumnBuilder::text(),
            'cover' => ColumnBuilder::string(),
            'filename' => ColumnBuilder::string(),
            'fileLocation' => ColumnBuilder::string(),
            'narrator' => ColumnBuilder::string(),
            'bitrate' => ColumnBuilder::string(),
            'boughtFrom' => ColumnBuilder::string(),
            'duration' => ColumnBuilder::integer(), // in minutes
            'sizeBytes' => ColumnBuilder::integer(), // in KB
            'orderInSeries' => ColumnBuilder::integer(),
            'publisherId' => ColumnBuilder::integer(),
            'seriesId' => ColumnBuilder::integer(),
            'collectionId' => ColumnBuilder::integer(),
            'duplicatesId' => ColumnBuilder::integer(),
        ]);
    }

    public function down(MigrationBuilder $b): void {
        $b->dropTable('item');
    }
}
