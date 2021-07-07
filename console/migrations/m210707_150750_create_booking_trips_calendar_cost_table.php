<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_trips_calendar_cost}}`.
 */
class m210707_150750_create_booking_trips_calendar_cost_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_trips_calendar_cost}}', [
            'id' => $this->primaryKey(),
            'trip_id' => $this->integer()->notNull(),
            'trip_at' => $this->integer()->notNull(),
            'quantity' => $this->integer(),
            'cost_base' => $this->integer()->notNull(),
            'cost_list_json' => 'JSON NOT NULL',
        ]);

        $this->createIndex('{{%idx-booking_trips_calendar_cost-trip_id}}', '{{%booking_trips_calendar_cost}}', 'trip_id');
        $this->addForeignKey(
            '{{%idx-booking_trips_calendar_cost-trip_id}}',
            '{{%booking_trips_calendar_cost}}',
            'trip_id',
            '{{%booking_trips}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_trips_calendar_cost}}');
    }
}
