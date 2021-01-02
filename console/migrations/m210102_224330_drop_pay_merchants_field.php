<?php

use yii\db\Migration;

/**
 * Class m210102_224330_drop_pay_merchants_field
 */
class m210102_224330_drop_pay_merchants_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%booking_tours_calendar_booking}}', 'pay_merchant');
        $this->dropColumn('{{%booking_cars_calendar_booking}}', 'pay_merchant');
        $this->dropColumn('{{%booking_funs_calendar_booking}}', 'pay_merchant');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%booking_tours_calendar_booking}}', 'pay_merchant', $this->float());
        $this->addColumn('{{%booking_cars_calendar_booking}}', 'pay_merchant', $this->float());
        $this->addColumn('{{%booking_funs_calendar_booking}}', 'pay_merchant', $this->float());
    }

}
