<?php

use yii\db\Migration;

/**
 * Class m200902_090008_add_booking_tours_calendar_booking_field
 */
class m200902_090008_add_booking_tours_calendar_booking_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_tours_calendar_booking}}', 'created_at', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_tours_calendar_booking}}', 'created_at');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200902_090008_add_booking_tours_calendar_booking_field cannot be reverted.\n";

        return false;
    }
    */
}
