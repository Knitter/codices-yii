<?php

use yii\db\Migration;

/**
 * Class m230708_224141_initial_schema
 */
final class m230708_224141_initial_schema extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $tableOptions = null;
        $stringMethod = 'text';
        if ($this->db->driverName === 'mysql') {
            $stringMethod = 'string';
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%account}}', [
            'id' => $this->primaryKey(),
            'username' => $this->$stringMethod()->notNull()->unique(),
            'email' => $this->$stringMethod()->notNull(),
            'authKey' => $this->$stringMethod(),
            'name' => $this->$stringMethod()->notNull(),
            'active' => $this->boolean()->notNull(),
            'password' => $this->$stringMethod()->notNull(),
            'resetToken' => $this->$stringMethod()->unique(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%publisher}}', [
            'id' => $this->primaryKey(),
            'name' => $this->$stringMethod()->notNull(),
            'ownedById' => $this->integer()->notNull(),
            'summary' => $this->$stringMethod(),
            'website' => $this->$stringMethod(),
            'logo' => $this->$stringMethod()
        ], $tableOptions);
        $this->addForeignKey('fkPublisherAccount', '{{%publisher}}', 'ownedById', '{{%account}}', 'id');

        $this->createTable('{{%series}}', [
            'id' => $this->primaryKey(),
            'name' => $this->$stringMethod()->notNull(),
            'ownedById' => $this->integer()->notNull(),
            'finished' => $this->boolean()->notNull(),
            'bookCount' => $this->integer(),
            'ownedCount' => $this->integer()
        ], $tableOptions);
        $this->addForeignKey('fkSeriesAccount', '{{%series}}', 'ownedById', '{{%account}}', 'id');

        $this->createTable('{{%book}}', [
            'id' => $this->primaryKey(),
            'title' => $this->$stringMethod()->notNull(),
            'ownedById' => $this->integer()->notNull(),
            'translated' => $this->boolean()->notNull(),
            'favorite' => $this->boolean()->notNull(),
            'read' => $this->boolean()->notNull(),
            'copies' => $this->integer()->notNull(),
            'subtitle' => $this->$stringMethod(),
            'originalTitle' => $this->$stringMethod(),
            'plot' => $this->text(),
            'isbn' => $this->$stringMethod(25),
            'format' => $this->$stringMethod(5),
            'pageCount' => $this->integer(),
            'publishDate' => $this->date(),
            'publishYear' => $this->integer(),
            'addedOn' => $this->dateTime(),
            'language' => $this->$stringMethod(),
            'translations' => $this->$stringMethod(),
            'edition' => $this->$stringMethod(),
            'publisherId' => $this->integer(),
            'rating' => $this->float(),
            'ownRating' => $this->float(),
            'url' => $this->$stringMethod(),
            'review' => $this->text(),
            'cover' => $this->$stringMethod(),
            'filename' => $this->$stringMethod(),
            'orderInSeries' => $this->integer(),
            'seriesId' => $this->integer(),
            'duplicatesBookId' => $this->integer()
        ], $tableOptions);
        $this->addForeignKey('fkBookAccount', '{{%book}}', 'ownedById', '{{%account}}', 'id');
        $this->addForeignKey('fkBookPublisher', '{{%book}}', 'publisherId', '{{%publisher}}', 'id');
        $this->addForeignKey('fkBookSeries', '{{%book}}', 'seriesId', '{{%series}}', 'id');
        $this->addForeignKey('fkBookBook', '{{%book}}', 'duplicatesBookId', '{{%book}}', 'id');

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%book}}');
        $this->dropTable('{{%series}}');
        $this->dropTable('{{%publisher}}');
        $this->dropTable('{{%account}}');

        return true;
    }
}
