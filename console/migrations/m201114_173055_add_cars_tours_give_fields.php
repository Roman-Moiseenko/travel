<?php

use yii\db\Migration;

/**
 * Class m201114_173055_add_cars_tours_give_fields
 */
class m201114_173055_add_cars_tours_give_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_cars_calendar_booking}}', 'give_out', $this->boolean()->defaultValue(false));
        $this->addColumn('{{%booking_cars_calendar_booking}}', 'give_at', $this->integer());

        $this->addColumn('{{%booking_tours_calendar_booking}}', 'give_out', $this->boolean()->defaultValue(false));
        $this->addColumn('{{%booking_tours_calendar_booking}}', 'give_at', $this->integer());

        $this->update('{{%booking_cars_calendar_booking}}', ['give_out' => false]);
        $this->update('{{%booking_tours_calendar_booking}}', ['give_out' => false]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_cars_calendar_booking}}', 'give_out');
        $this->dropColumn('{{%booking_cars_calendar_booking}}', 'give_at');

        $this->dropColumn('{{%booking_tours_calendar_booking}}', 'give_out');
        $this->dropColumn('{{%booking_tours_calendar_booking}}', 'give_at');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201114_173055_add_cars_tours_give_fields cannot be reverted.\n";

        return false;
    }
    */
}
