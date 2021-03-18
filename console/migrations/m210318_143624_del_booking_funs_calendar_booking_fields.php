<?php

use yii\db\Migration;

/**
 * Class m210318_143624_del_booking_funs_calendar_booking_fields
 */
class m210318_143624_del_booking_funs_calendar_booking_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%booking_funs_calendar_booking}}', 'payment_confirmation', $this->string()->defaultValue(''));
        $this->update('{{%booking_funs_calendar_booking}}', ['payment_confirmation' => '']);
        $this->dropColumn('{{%booking_funs_calendar_booking}}', 'confirmation');
        $this->dropColumn('{{%booking_funs_calendar_booking}}', 'payment_at');

        $this->dropForeignKey( '{{%fk-booking_funs_calendar_booking-fun_id}}', '{{%booking_funs_calendar_booking}}');
        $this->dropIndex('{{%idx-booking_funs_calendar_booking-fun_id}}', '{{%booking_funs_calendar_booking}}');

        $this->dropColumn('{{%booking_funs_calendar_booking}}', 'fun_id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210318_143624_del_booking_funs_calendar_booking_fields cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210318_143624_del_booking_funs_calendar_booking_fields cannot be reverted.\n";

        return false;
    }
    */
}
