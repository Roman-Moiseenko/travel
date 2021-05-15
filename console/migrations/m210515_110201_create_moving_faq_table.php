<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%moving_faq}}`.
 */
class m210515_110201_create_moving_faq_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%moving_faq}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'category_id' => $this->integer(),
            'message' => $this->text(),
            'complete' => $this->boolean(),
        ], $tableOptions);

        $this->createIndex('{{%idx-moving_faq-user_id}}', '{{%moving_faq}}', 'user_id');
        $this->createIndex('{{%idx-moving_faq-category_id}}', '{{%moving_faq}}', 'category_id');

        $this->addForeignKey('{{%fk-moving_faq-user_id}}',
            '{{%moving_faq}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE',
            'RESTRICT');
        $this->addForeignKey('{{%fk-moving_faq-category_id}}',
            '{{%moving_faq}}',
            'category_id',
            '{{%moving_faq_category}}',
            'id',
            'CASCADE',
            'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%moving_faq}}');
    }
}
