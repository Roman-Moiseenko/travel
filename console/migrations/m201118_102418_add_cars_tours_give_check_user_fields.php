<?php

use yii\db\Migration;

/**
 * Class m201118_102418_add_cars_tours_give_check_user_fields
 */
class m201118_102418_add_cars_tours_give_check_user_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_cars_calendar_booking}}', 'give_user_id', $this->integer());
        $this->addColumn('{{%booking_tours_calendar_booking}}', 'give_user_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_cars_calendar_booking}}', 'give_user_id');
        $this->dropColumn('{{%booking_tours_calendar_booking}}', 'give_user_id');
    }

}
