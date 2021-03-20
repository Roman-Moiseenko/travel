<?php

use yii\db\Migration;

/**
 * Class m210320_173720_del_bookings_check_booking_field
 */
class m210320_173720_del_bookings_check_booking_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%booking_tours}}', 'check_booking');
        $this->dropColumn('{{%booking_stays}}', 'check_booking');
        $this->dropColumn('{{%booking_cars}}', 'check_booking');
        $this->dropColumn('{{%booking_funs}}', 'check_booking');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210320_173720_del_bookings_check_booking_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210320_173720_del_bookings_check_booking_field cannot be reverted.\n";

        return false;
    }
    */
}
