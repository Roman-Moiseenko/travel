<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_stays_duty}}`.
 */
class m210225_081457_create_booking_stays_duty_assign_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_stays_duty_assign}}', [
            'stay_id' => $this->integer()->notNull(),
            'duty_id' => $this->integer()->notNull(),
            'payment' => $this->integer()->notNull(),
            'value' => $this->integer()->notNull(),
            'include' => $this->boolean(),
        ]);

        $this->addPrimaryKey('{{%pk-booking_stays_duty_assign}}', '{{%booking_stays_duty_assign}}', ['stay_id', 'duty_id']);

        $this->createIndex('{{%idx-booking_stays_duty_assign-stay_id}}', '{{%booking_stays_duty_assign}}', 'stay_id');
        $this->createIndex('{{%idx-booking_stays_duty_assign-duty_id}}', '{{%booking_stays_duty_assign}}', 'duty_id');
        $this->addForeignKey('{{%fk-booking_stays_duty_assign-stay_id}}', '{{%booking_stays_duty_assign}}', 'stay_id', '{{%booking_stays}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-booking_stays_duty_assign-duty_id}}', '{{%booking_stays_duty_assign}}', 'duty_id', '{{%booking_stays_duty}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_stays_duty}}');
    }
}
