<?php

use yii\db\Migration;

/**
 * Class m210318_133139_del_booking_tours_calendar_booking_fields
 */
class m210318_133139_del_booking_tours_calendar_booking_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%booking_tours_calendar_booking}}', 'payment_confirmation', $this->string()->defaultValue(''));
        $this->update('{{%booking_tours_calendar_booking}}', ['payment_confirmation' => '']);
        $this->dropColumn('{{%booking_tours_calendar_booking}}', 'confirmation');
        $this->dropColumn('{{%booking_tours_calendar_booking}}', 'payment_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210318_133139_del_booking_tours_calendar_booking_fields cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210318_133139_del_booking_tours_calendar_booking_fields cannot be reverted.\n";

        return false;
    }
    */
}
