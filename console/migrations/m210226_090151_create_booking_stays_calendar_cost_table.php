<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_stays_calendar_cost}}`.
 */
class m210226_090151_create_booking_stays_calendar_cost_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_stays_calendar_cost}}', [
            'id' => $this->primaryKey(),
            'stay_id' => $this->integer()->notNull(),
            'stay_at' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull(),
            'cost_base' => $this->integer()->notNull(),
            'guest_base' => $this->integer(),
            'cost_add' => $this->integer(),
        ]);
        $this->createIndex('{{%idx-booking_stays_calendar_cost-stay_id}}', '{{%booking_stays_calendar_cost}}','stay_id');
        $this->addForeignKey('{{%fk-booking_stays_calendar_cost-stay_id}}', '{{%booking_stays_calendar_cost}}', 'stay_id', '{{%booking_stays}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-booking_stays_calendar_cost-unique}}',
            '{{%booking_stays_calendar_cost}}',
            ['stay_id', 'stay_at'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_stays_calendar_cost}}');
    }
}
