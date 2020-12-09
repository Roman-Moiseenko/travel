<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_funs_reviews}}`.
 */
class m201201_220825_create_booking_funs_reviews_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_funs_reviews}}', [
            'id' => $this->primaryKey(),
            'fun_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'vote' => $this->integer()->notNull(),
            'text' => $this->text()->notNull(),
            'status' => $this->integer()->defaultValue(1)
        ], $tableOptions);
        $this->createIndex('{{%idx-booking_funs_reviews-user_id}}', '{{%booking_funs_reviews}}', 'user_id');
        $this->createIndex('{{%idx-booking_funs_reviews-fun_id}}', '{{%booking_funs_reviews}}', 'fun_id');
        $this->addForeignKey('{{%fk-booking_funs_reviews-fun_id}}', '{{%booking_funs_reviews}}', 'fun_id', '{{%booking_funs}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-booking_funs_reviews-user_id}}', '{{%booking_funs_reviews}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_funs_reviews}}');
    }
}
