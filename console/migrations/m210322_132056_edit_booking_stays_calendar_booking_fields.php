<?php

use yii\db\Migration;

/**
 * Class m210322_132056_edit_booking_stays_calendar_booking_fields
 */
class m210322_132056_edit_booking_stays_calendar_booking_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%booking_stays_calendar_booking}}', 'confirmation');
        $this->dropColumn('{{%booking_stays_calendar_booking}}', 'pay_merchant');
        $this->dropColumn('{{%booking_stays_calendar_booking}}', 'guest_add');
        $this->addColumn('{{%booking_stays_calendar_booking}}', 'guest', $this->integer()->notNull());
        $this->addColumn('{{%booking_stays_calendar_booking}}', 'children', $this->integer());

        $this->dropForeignKey('{{%fk-booking_stays_calendar_booking-stay_id}}', '{{%booking_stays_calendar_booking}}');
        $this->dropIndex('{{%idx-booking_stays_calendar_booking-stay_id}}', '{{%booking_stays_calendar_booking}}');
        $this->dropColumn( '{{%booking_stays_calendar_booking}}', 'stay_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210322_132056_edit_booking_stays_calendar_booking_fields cannot be reverted.\n";

        return false;
    }

}
