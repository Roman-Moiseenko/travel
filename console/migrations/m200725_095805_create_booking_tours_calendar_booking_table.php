<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_tours_calendar_booking}}`.
 */
class m200725_095805_create_booking_tours_calendar_booking_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_tours_calendar_booking}}', [
            'id' => $this->primaryKey(),
            'tours_id' => $this->integer(),
            'user_id' => $this->integer(),
            'tour_at' => $this->integer(),
            'amount' => $this->integer(),
            'count_adult' => $this->integer(),
            'count_child' => $this->integer(),
            'count_preference' => $this->integer(),
        ], $tableOptions);
        $this->createIndex('{{%idx-booking_tours_calendar_booking-tours_id}}', '{{%booking_tours_calendar_booking}}','tours_id');
        $this->addForeignKey('{{%fk-booking_tours_calendar_booking-tours_id}}', '{{%booking_tours_calendar_booking}}', 'tours_id', '{{%booking_tours}}', 'id', 'SET NULL', 'RESTRICT');

        $this->createIndex('{{%idx-booking_tours_calendar_booking-user_id}}', '{{%booking_tours_calendar_booking}}','user_id');
        $this->addForeignKey('{{%fk-booking_tours_calendar_booking-user_id}}', '{{%booking_tours_calendar_booking}}', 'user_id', '{{%users}}', 'id', 'SET NULL', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_tours_calendar_booking}}');
    }
}
