<?php

use yii\db\Migration;

/**
 * Class m210707_175215_add_booking_trips_calendar_cost_cost_params_field
 */
class m210707_175215_add_booking_trips_calendar_cost_cost_params_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_trips_calendar_cost}}', 'params_json', 'JSON NOT NULL');
        $this->update('{{%booking_trips_calendar_cost}}', ['params_json' => json_encode([])]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210707_175215_add_booking_trips_calendar_cost_cost_params_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210707_175215_add_booking_trips_calendar_cost_cost_params_field cannot be reverted.\n";

        return false;
    }
    */
}
