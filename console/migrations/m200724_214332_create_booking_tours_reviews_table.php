<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_tours_reviews}}`.
 */
class m200724_214332_create_booking_tours_reviews_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%booking_tours_reviews}}', [
            'id' => $this->primaryKey(),
            'tours_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'vote' => $this->integer()->notNull(),
            'text' => $this->text()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-booking_tours_reviews-user_id}}', '{{%booking_tours_reviews}}', 'user_id');
        $this->createIndex('{{%idx-booking_tours_reviews-tours_id}}', '{{%booking_tours_reviews}}', 'tours_id');
        $this->addForeignKey('{{%fk-booking_tours_reviews-tours_id}}', '{{%booking_tours_reviews}}', 'tours_id', '{{%booking_tours}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-booking_tours_reviews-user_id}}', '{{%booking_tours_reviews}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_tours_reviews}}');
    }
}
