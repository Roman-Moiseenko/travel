<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_stays_calendar_booking_service}}`.
 */
class m210227_205743_create_booking_stays_calendar_booking_service_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_stays_calendar_booking_service}}', [
            'id' => $this->primaryKey(),
            'booking_id' => $this->integer()->notNull(),
            'name' => $this->string(),
            'value' => $this->integer()->notNull(),
            'payment' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->createIndex('{{%idx-booking_stays_calendar_booking_service-booking_id}}', '{{%booking_stays_calendar_booking_service}}', 'booking_id');
        $this->addForeignKey('{{%fk-booking_stays_calendar_booking_service-booking_id}}', '{{%booking_stays_calendar_booking_service}}', 'booking_id', 'booking_stays_calendar_booking', 'id', 'CASCADE' );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_stays_calendar_booking_service}}');
    }
}
