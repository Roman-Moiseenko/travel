<?php

use yii\db\Migration;

/**
 * Class m210318_111802_edit_booking_cars_calendar_booking_car_id_field
 */
class m210318_111802_edit_booking_cars_calendar_booking_car_id_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%booking_cars_calendar_booking}}', 'car_id', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210318_111802_edit_booking_cars_calendar_booking_car_id_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210318_111802_edit_booking_cars_calendar_booking_car_id_field cannot be reverted.\n";

        return false;
    }
    */
}
