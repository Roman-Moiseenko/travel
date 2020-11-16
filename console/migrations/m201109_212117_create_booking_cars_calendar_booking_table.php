<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_cars_calendar_booking}}`.
 */
class m201109_212117_create_booking_cars_calendar_booking_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_cars_calendar_booking}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'car_id' => $this->integer()->notNull(),
            'status' => $this->integer(),
            'confirmation' => $this->string(),
            'created_at' => $this->integer(),
            'begin_at' => $this->integer(),
            'end_at' => $this->integer(),
            'pincode' => $this->integer(),
            'unload' => $this->boolean(),
            'count' => $this->integer(),
            'comment' => $this->string(),
            'discount_id' => $this->integer(),
            'bonus' => $this->integer(),
            'payment_provider' => $this->float(),
            'pay_merchant' => $this->float(),
            'payment_id' => $this->string(),
        ]);
        $this->createIndex('{{%idx-booking_cars_calendar_booking-user_id}}', '{{%booking_cars_calendar_booking}}', 'user_id');
        $this->addForeignKey('{{%fk-booking_cars_calendar_booking-user_id}}', '{{%booking_cars_calendar_booking}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'RESTRICT');
        $this->createIndex('{{%idx-booking_cars_calendar_booking-car_id}}', '{{%booking_cars_calendar_booking}}', 'car_id');
        $this->addForeignKey('{{%fk-booking_cars_calendar_booking-car_id}}', '{{%booking_cars_calendar_booking}}', 'car_id', '{{%booking_cars}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_cars_calendar_booking}}');
    }
}
