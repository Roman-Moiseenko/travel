<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%night_review}}`.
 */
class m210730_201023_create_night_review_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%night_review}}', [
            'id' => $this->primaryKey(),
            'page_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'text' => $this->string()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-night_review-page_id}}', '{{%night_review}}', 'page_id');
        $this->createIndex('{{%idx-night_review-user_id}}', '{{%night_review}}', 'user_id');

        $this->addForeignKey(
            '{{%fk-night_review-page_id}}',
            '{{%night_review}}',
            'page_id',
            '{{%night_pages}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );

        $this->addForeignKey(
            '{{%fk-night_review-user_id}}',
            '{{%night_review}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%night_review}}');
    }
}
