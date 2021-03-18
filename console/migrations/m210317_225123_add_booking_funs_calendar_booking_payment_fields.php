<?php

use yii\db\Migration;

/**
 * Class m210317_225123_add_booking_funs_calendar_booking_payment_fields
 */
class m210317_225123_add_booking_funs_calendar_booking_payment_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_funs_calendar_booking}}', 'payment_date', $this->integer());
        $this->addColumn('{{%booking_funs_calendar_booking}}', 'payment_full_cost', $this->integer());
        $this->addColumn('{{%booking_funs_calendar_booking}}', 'payment_prepay', $this->integer());
        $this->addColumn('{{%booking_funs_calendar_booking}}', 'payment_percent', $this->integer());
        $this->addColumn('{{%booking_funs_calendar_booking}}', 'payment_confirmation', $this->string());

        $this->addColumn('{{%booking_funs_calendar_booking}}', 'object_id', $this->integer());
        $this->addColumn('{{%booking_funs_calendar_booking}}', 'legal_id', $this->integer());


        $this->addColumn('{{%booking_funs}}', 'prepay', $this->integer());
        $this->update('{{%booking_funs}}', ['prepay' => 100]);


        $this->createIndex('{{%idx-booking_funs_calendar_booking-object_id}}', '{{%booking_funs_calendar_booking}}', 'object_id');
        $this->addForeignKey(
            '{{%fk-booking_funs_calendar_booking-object_id}}',
            '{{%booking_funs_calendar_booking}}',
            'object_id',
            '{{%booking_funs}}',
            'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-booking_funs_calendar_booking-legal_id}}', '{{%booking_funs_calendar_booking}}', 'legal_id');
        $this->addForeignKey(
            '{{%fk-booking_funs_calendar_booking-legal_id}}',
            '{{%booking_funs_calendar_booking}}',
            'legal_id',
            '{{%admin_user_legals}}',
            'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_funs_calendar_booking}}', 'payment_date');
        $this->dropColumn('{{%booking_funs_calendar_booking}}', 'payment_full_cost');
        $this->dropColumn('{{%booking_funs_calendar_booking}}', 'payment_prepay');
        $this->dropColumn('{{%booking_funs_calendar_booking}}', 'payment_percent');
        $this->dropColumn('{{%booking_funs_calendar_booking}}', 'payment_confirmation');

        $this->dropColumn('{{%booking_funs_calendar_booking}}', 'object_id');
        $this->dropColumn('{{%booking_funs_calendar_booking}}', 'legal_id');



        $this->dropColumn('{{%booking_funs}}', 'prepay');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210317_225123_add_booking_funs_calendar_booking_payment_fields cannot be reverted.\n";

        return false;
    }
    */
}
