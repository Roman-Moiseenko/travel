<?php

use yii\db\Migration;

/**
 * Class m210317_231730_add_booking_stays_calendar_booking_payment_fields
 */
class m210317_231730_add_booking_stays_calendar_booking_payment_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_stays_calendar_booking}}', 'payment_date', $this->integer());
        $this->addColumn('{{%booking_stays_calendar_booking}}', 'payment_full_cost', $this->integer());
        $this->addColumn('{{%booking_stays_calendar_booking}}', 'payment_prepay', $this->integer());
        $this->addColumn('{{%booking_stays_calendar_booking}}', 'payment_percent', $this->integer());
        $this->addColumn('{{%booking_stays_calendar_booking}}', 'payment_confirmation', $this->string());

        $this->addColumn('{{%booking_stays_calendar_booking}}', 'object_id', $this->integer());
        $this->addColumn('{{%booking_stays_calendar_booking}}', 'legal_id', $this->integer());


        $this->addColumn('{{%booking_stays}}', 'prepay', $this->integer());
        $this->update('{{%booking_stays}}', ['prepay' => 100]);


        $this->createIndex('{{%idx-booking_stays_calendar_booking-object_id}}', '{{%booking_stays_calendar_booking}}', 'object_id');
        $this->addForeignKey(
            '{{%fk-booking_stays_calendar_booking-object_id}}',
            '{{%booking_stays_calendar_booking}}',
            'object_id',
            '{{%booking_stays}}',
            'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-booking_stays_calendar_booking-legal_id}}', '{{%booking_stays_calendar_booking}}', 'legal_id');
        $this->addForeignKey(
            '{{%fk-booking_stays_calendar_booking-legal_id}}',
            '{{%booking_stays_calendar_booking}}',
            'legal_id',
            '{{%admin_user_legals}}',
            'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_stays_calendar_booking}}', 'payment_date');
        $this->dropColumn('{{%booking_stays_calendar_booking}}', 'payment_full_cost');
        $this->dropColumn('{{%booking_stays_calendar_booking}}', 'payment_prepay');
        $this->dropColumn('{{%booking_stays_calendar_booking}}', 'payment_percent');
        $this->dropColumn('{{%booking_stays_calendar_booking}}', 'payment_confirmation');

        $this->dropColumn('{{%booking_stays_calendar_booking}}', 'object_id');
        $this->dropColumn('{{%booking_stays_calendar_booking}}', 'legal_id');

        $this->dropColumn('{{%booking_stays}}', 'prepay');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210317_231730_add_booking_stays_calendar_booking_payment_fields cannot be reverted.\n";

        return false;
    }
    */
}
