<?php

use yii\db\Migration;

/**
 * Class m200913_222005_add_booking_tours_calendar_booking_confirmation_field
 */
class m200913_222005_add_booking_tours_calendar_booking_confirmation_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_tours_calendar_booking}}', 'confirmation', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_tours_calendar_booking}}', 'confirmation');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200913_222005_add_booking_tours_calendar_booking_confirmation_field cannot be reverted.\n";

        return false;
    }
    */
}
