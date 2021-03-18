<?php

use yii\db\Migration;

/**
 * Class m210317_190325_add_booking_tours_calendar_booking
 */
class m210317_190325_add_booking_tours_calendar_booking_payment_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_tours_calendar_booking}}', 'payment_date', $this->integer());
        $this->addColumn('{{%booking_tours_calendar_booking}}', 'payment_full_cost', $this->integer());
        $this->addColumn('{{%booking_tours_calendar_booking}}', 'payment_prepay', $this->integer());
        $this->addColumn('{{%booking_tours_calendar_booking}}', 'payment_percent', $this->integer());
        $this->addColumn('{{%booking_tours_calendar_booking}}', 'payment_confirmation', $this->string());

        $this->addColumn('{{%booking_tours_calendar_booking}}', 'object_id', $this->integer());
        $this->addColumn('{{%booking_tours_calendar_booking}}', 'legal_id', $this->integer());
        $this->addColumn('{{%booking_tours_calendar_booking}}', 'comment', $this->text());

        $this->addColumn('{{%booking_tours}}', 'prepay', $this->integer());
        $this->addColumn('{{%booking_tours}}', 'params_annotation', $this->string());
        $this->update('{{%booking_tours}}', ['prepay' => 100]);


        $this->createIndex('{{%idx-booking_tours_calendar_booking-object_id}}', '{{%booking_tours_calendar_booking}}', 'object_id');
        $this->addForeignKey(
            '{{%fk-booking_tours_calendar_booking-object_id}}',
            '{{%booking_tours_calendar_booking}}',
            'object_id',
            '{{%booking_tours}}',
            'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-booking_tours_calendar_booking-legal_id}}', '{{%booking_tours_calendar_booking}}', 'legal_id');
        $this->addForeignKey(
            '{{%fk-booking_tours_calendar_booking-legal_id}}',
            '{{%booking_tours_calendar_booking}}',
            'legal_id',
            '{{%admin_user_legals}}',
            'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_tours_calendar_booking}}', 'payment_date');
        $this->dropColumn('{{%booking_tours_calendar_booking}}', 'payment_full_cost');
        $this->dropColumn('{{%booking_tours_calendar_booking}}', 'payment_prepay');
        $this->dropColumn('{{%booking_tours_calendar_booking}}', 'payment_percent');
        $this->dropColumn('{{%booking_tours_calendar_booking}}', 'payment_confirmation');

        $this->dropColumn('{{%booking_tours_calendar_booking}}', 'object_id');
        $this->dropColumn('{{%booking_tours_calendar_booking}}', 'legal_id');
        $this->dropColumn('{{%booking_tours_calendar_booking}}', 'comment');


        $this->dropColumn('{{%booking_tours}}', 'prepay');
        $this->dropColumn('{{%booking_tours}}', 'params_annotation');
    }

}
