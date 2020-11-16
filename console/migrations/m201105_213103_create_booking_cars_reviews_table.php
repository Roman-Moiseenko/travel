<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_cars_reviews}}`.
 */
class m201105_213103_create_booking_cars_reviews_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_cars_reviews}}', [
            'id' => $this->primaryKey(),
            'car_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'vote' => $this->integer()->notNull(),
            'text' => $this->text()->notNull(),
            'status' => $this->integer()->defaultValue(1)
        ], $tableOptions);
        $this->createIndex('{{%idx-booking_cars_reviews-user_id}}', '{{%booking_cars_reviews}}', 'user_id');
        $this->createIndex('{{%idx-booking_cars_reviews-car_id}}', '{{%booking_cars_reviews}}', 'car_id');
        $this->addForeignKey('{{%fk-booking_cars_reviews-car_id}}', '{{%booking_cars_reviews}}', 'car_id', '{{%booking_cars}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-booking_cars_reviews-user_id}}', '{{%booking_cars_reviews}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_cars_reviews}}');
    }
}
