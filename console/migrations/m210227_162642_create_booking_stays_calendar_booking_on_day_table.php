<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_stays_calendar_booking_on_day}}`.
 */
class m210227_162642_create_booking_stays_calendar_booking_on_day_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_stays_calendar_booking_on_day}}', [
            'booking_id' => $this->integer()->notNull(),
            'calendar_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-booking_stays_calendar_booking_on_day}}', '{{%booking_stays_calendar_booking_on_day}}', ['booking_id', 'calendar_id']);

        $this->createIndex('{{%idx-booking_stays_calendar_booking_on_day-booking_id}}', '{{%booking_stays_calendar_booking_on_day}}', 'booking_id');
        $this->createIndex('{{%idx-booking_stays_calendar_booking_on_day-calendar_id}}', '{{%booking_stays_calendar_booking_on_day}}', 'calendar_id');

        $this->addForeignKey('{{%fk-booking_stays_calendar_booking_on_day-booking_id}}', '{{%booking_stays_calendar_booking_on_day}}', 'booking_id', '{{%booking_stays_calendar_booking}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-booking_stays_calendar_booking_on_day-calendar_id}}', '{{%booking_stays_calendar_booking_on_day}}', 'calendar_id', '{{%booking_stays_calendar_cost}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_stays_calendar_booking_on_day}}');
    }
}
