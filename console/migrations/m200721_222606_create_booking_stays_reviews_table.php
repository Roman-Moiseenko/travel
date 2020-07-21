<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_stays_reviews}}`.
 */
class m200721_222606_create_booking_stays_reviews_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%booking_stays_reviews}}', [
            'id' => $this->primaryKey(),
            'stays_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'vote' => $this->integer()->notNull(),
            'text' => $this->text()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-booking_stays_reviews-user_id}}', '{{%booking_stays_reviews}}', 'user_id');
        $this->createIndex('{{%idx-booking_stays_reviews-product_id}}', '{{%booking_stays_reviews}}', 'stays_id');
        $this->addForeignKey('{{%fk-booking_stays_reviews-product_id}}', '{{%booking_stays_reviews}}', 'stays_id', '{{%booking_stays}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-booking_stays_reviews-user_id}}', '{{%booking_stays_reviews}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_stays_reviews}}');
    }
}
