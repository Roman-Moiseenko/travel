<?php

use yii\db\Migration;

/**
 * Class m200902_212034_add_booking_tours_calendar_booking_field
 */
class m200902_212034_add_booking_tours_calendar_booking_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_tours_calendar_booking}}', 'discount_id', $this->integer());
        $this->dropColumn('{{%booking_tours_calendar_booking}}', 'amount');
        $this->createIndex('{{%idx-booking_tours_calendar_booking-discount_id}}', '{{%booking_tours_calendar_booking}}', 'discount_id');
        $this->addForeignKey('{{%fk-booking_tours_calendar_booking-discount_id}}', '{{%booking_tours_calendar_booking}}', 'discount_id', '{{%booking_discount}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_tours_calendar_booking}}', 'discount_id');
        $this->addColumn('{{%booking_tours_calendar_booking}}', 'amount', $this->integer());
        $this->dropForeignKey('{{%fk-booking_tours_calendar_booking-discount_id}}', '{{%booking_tours_calendar_booking}}');
        $this->dropIndex('{{%idx-booking_tours_calendar_booking-discount_id}}', '{{%booking_tours_calendar_booking}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200902_212034_add_booking_tours_calendar_booking_field cannot be reverted.\n";

        return false;
    }
    */
}
