<?php

use yii\db\Migration;

/**
 * Class m200905_165543_add_booking_tours_calendar_booking_bonus_field
 */
class m200905_165543_add_booking_tours_calendar_booking_bonus_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_tours_calendar_booking}}', 'bonus', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_tours_calendar_booking}}', 'bonus');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200905_165543_add_booking_tours_calendar_booking_bonus_field cannot be reverted.\n";

        return false;
    }
    */
}
