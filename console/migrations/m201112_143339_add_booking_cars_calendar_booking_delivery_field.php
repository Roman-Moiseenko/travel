<?php

use yii\db\Migration;

/**
 * Class m201112_143339_add_booking_cars_calendar_booking_delivery_field
 */
class m201112_143339_add_booking_cars_calendar_booking_delivery_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_cars_calendar_booking}}', 'delivery', $this->boolean());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_cars_calendar_booking}}', 'delivery');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201112_143339_add_booking_cars_calendar_booking_delivery_field cannot be reverted.\n";

        return false;
    }
    */
}
