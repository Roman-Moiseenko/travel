<?php

use yii\db\Migration;

/**
 * Class m210320_182722_del_cost_calendars_status_field
 */
class m210320_182722_del_cost_calendars_status_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%booking_tours_calendar_cost}}', 'status');
        $this->dropColumn('{{%booking_stays_calendar_cost}}', 'status');
        $this->dropColumn('{{%booking_funs_calendar_cost}}', 'status');
        $this->dropColumn('{{%booking_cars_calendar_cost}}', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210320_182722_del_cost_calendars_status_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210320_182722_del_cost_calendars_status_field cannot be reverted.\n";

        return false;
    }
    */
}
