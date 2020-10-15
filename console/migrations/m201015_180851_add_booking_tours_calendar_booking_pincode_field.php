<?php

use yii\db\Migration;

/**
 * Class m201015_180851_add_booking_tours_calendar_booking_pincode_field
 */
class m201015_180851_add_booking_tours_calendar_booking_pincode_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_tours_calendar_booking}}', 'pincode', $this->integer()->defaultValue(0));
        $this->update('{{%booking_tours_calendar_booking}}', ['pincode' => rand(1001, 9900)]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_tours_calendar_booking}}', 'pincode');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201015_180851_add_booking_tours_calendar_booking_pincode_field cannot be reverted.\n";

        return false;
    }
    */
}
