<?php

use yii\db\Migration;

/**
 * Class m201027_215011_add_booking_tours_calendar_booking_payment_id_field
 */
class m201027_215011_add_booking_tours_calendar_booking_payment_id_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_tours_calendar_booking}}', 'payment_id', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_tours_calendar_booking}}', 'payment_id');
    }

}
