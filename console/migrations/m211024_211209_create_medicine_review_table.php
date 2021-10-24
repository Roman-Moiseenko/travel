<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%medicine_review}}`.
 */
class m211024_211209_create_medicine_review_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%medicine_review}}', [
            'id' => $this->primaryKey(),
            'page_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'text' => $this->string()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-medicine_review-page_id}}', '{{%medicine_review}}', 'page_id');
        $this->createIndex('{{%idx-medicine_review-user_id}}', '{{%medicine_review}}', 'user_id');

        $this->addForeignKey(
            '{{%fk-medicine_review-page_id}}',
            '{{%medicine_review}}',
            'page_id',
            '{{%medicine_review}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );

        $this->addForeignKey(
            '{{%fk-medicine_review-user_id}}',
            '{{%medicine_review}}',
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
        $this->dropTable('{{%medicine_review}}');
    }
}
