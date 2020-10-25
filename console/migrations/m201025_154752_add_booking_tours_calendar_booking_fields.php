<?php

use yii\db\Migration;

/**
 * Class m201025_154752_add_booking_tours_calendar_booking_fields
 */
class m201025_154752_add_booking_tours_calendar_booking_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_tours_calendar_booking}}', 'pay_merchant', $this->float()->defaultValue(0));
        $this->addColumn('{{%booking_tours_calendar_booking}}', 'payment_provider', $this->float());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_tours_calendar_booking}}', 'pay_merchant');
        $this->dropColumn('{{%booking_tours_calendar_booking}}', 'payment_provider');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201025_154752_add_booking_tours_calendar_booking_fields cannot be reverted.\n";

        return false;
    }
    */
}
