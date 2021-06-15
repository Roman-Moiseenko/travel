<?php

use yii\db\Migration;

/**
 * Class m210614_214157_add_booking_tours_calendar_booking_services_fields
 */
class m210614_214157_add_booking_tours_calendar_booking_services_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_tours_calendar_booking}}', 'time_cost', $this->integer());
        $this->addColumn('{{%booking_tours_calendar_booking}}', 'time_count', $this->integer());
        $this->addColumn('{{%booking_tours_calendar_booking}}', 'capacity_count', $this->integer());
        $this->addColumn('{{%booking_tours_calendar_booking}}', 'capacity_percent', $this->integer());
        $this->addColumn('{{%booking_tours_calendar_booking}}', 'transfer_path', $this->string());
        $this->addColumn('{{%booking_tours_calendar_booking}}', 'transfer_cost', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_tours_calendar_booking}}', 'time_cost');
        $this->dropColumn('{{%booking_tours_calendar_booking}}', 'time_count');
        $this->dropColumn('{{%booking_tours_calendar_booking}}', 'capacity_count');
        $this->dropColumn('{{%booking_tours_calendar_booking}}', 'capacity_percent');
        $this->dropColumn('{{%booking_tours_calendar_booking}}', 'transfer_path');
        $this->dropColumn('{{%booking_tours_calendar_booking}}', 'transfer_cost');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210614_214157_add_booking_tours_calendar_booking_services_fields cannot be reverted.\n";

        return false;
    }
    */
}
