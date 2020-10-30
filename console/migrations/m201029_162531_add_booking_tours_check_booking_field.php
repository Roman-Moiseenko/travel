<?php

use booking\helpers\BookingHelper;
use yii\db\Migration;

/**
 * Class m201029_162531_add_booking_tours_check_booking_field
 */
class m201029_162531_add_booking_tours_check_booking_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_tours}}', 'check_booking', $this->integer()->defaultValue(BookingHelper::BOOKING_CONFIRMATION));
        $this->update('{{%booking_tours}}',['check_booking' => BookingHelper::BOOKING_CONFIRMATION]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_tours}}', 'check_booking');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201029_162531_add_booking_tours_check_booking_field cannot be reverted.\n";

        return false;
    }
    */
}
