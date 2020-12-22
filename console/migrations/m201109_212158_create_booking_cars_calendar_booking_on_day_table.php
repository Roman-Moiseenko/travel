<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_cars_calendar_booking_on_day}}`.
 */
class m201109_212158_create_booking_cars_calendar_booking_on_day_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_cars_calendar_booking_on_day}}', [
            'booking_id' => $this->integer()->notNull(),
            'calendar_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('{{%pk-booking_cars_calendar_booking_on_day}}', '{{%booking_cars_calendar_booking_on_day}}', ['booking_id', 'calendar_id']);

        $this->createIndex('{{%idx-booking_cars_calendar_booking_on_day-booking_id}}', '{{%booking_cars_calendar_booking_on_day}}', 'booking_id');
        $this->createIndex('{{%idx-booking_cars_calendar_booking_on_day-calendar_id}}', '{{%booking_cars_calendar_booking_on_day}}', 'calendar_id');

        $this->addForeignKey('{{%fk-booking_cars_calendar_booking_on_day-booking_id}}', '{{%booking_cars_calendar_booking_on_day}}', 'booking_id', '{{%booking_cars_calendar_booking}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-booking_cars_calendar_booking_on_day-calendar_id}}', '{{%booking_cars_calendar_booking_on_day}}', 'calendar_id', '{{%booking_cars_calendar_cost}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_cars_calendar_booking_on_day}}');
    }
}
