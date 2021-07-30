<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%moving_review}}`.
 */
class m210730_190604_create_moving_review_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%moving_review}}', [
            'id' => $this->primaryKey(),
            'page_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'text' => $this->string()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-moving_review-page_id}}', '{{%moving_review}}', 'page_id');
        $this->createIndex('{{%idx-moving_review-user_id}}', '{{%moving_review}}', 'user_id');

        $this->addForeignKey(
            '{{%fk-moving_review-page_id}}',
            '{{%moving_review}}',
            'page_id',
            '{{%moving_pages}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );

        $this->addForeignKey(
            '{{%fk-moving_review-user_id}}',
            '{{%moving_review}}',
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
        $this->dropTable('{{%moving_review}}');
    }
}
