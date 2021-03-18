<?php

use yii\db\Migration;

/**
 * Class m210318_151518_del_booking_calendar_booking_discount_fields
 */
class m210318_151518_del_booking_calendar_booking_discount_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('{{%fk-booking_tours_calendar_booking-discount_id}}', '{{%booking_tours_calendar_booking}}');
        $this->dropIndex('{{%idx-booking_tours_calendar_booking-discount_id}}', '{{%booking_tours_calendar_booking}}');
        $this->dropColumn('{{%booking_tours_calendar_booking}}', 'discount_id');
        $this->dropColumn('{{%booking_tours_calendar_booking}}', 'bonus');

        $this->dropColumn('{{%booking_stays_calendar_booking}}', 'discount_id');
        $this->dropColumn('{{%booking_stays_calendar_booking}}', 'bonus');

        $this->dropColumn('{{%booking_funs_calendar_booking}}', 'discount_id');
        $this->dropColumn('{{%booking_funs_calendar_booking}}', 'bonus');

        $this->dropColumn('{{%booking_cars_calendar_booking}}', 'discount_id');
        $this->dropColumn('{{%booking_cars_calendar_booking}}', 'bonus');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210318_151518_del_booking_calendar_booking_discount_fields cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210318_151518_del_booking_calendar_booking_discount_fields cannot be reverted.\n";

        return false;
    }
    */
}
