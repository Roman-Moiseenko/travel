<?php

use yii\db\Migration;

/**
 * Class m210623_151159_add_booking_trips_params_fields
 */
class m210623_151159_add_booking_trips_params_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_trips}}', 'params_duration', $this->integer());
        $this->addColumn('{{%booking_trips}}', 'params_transfer', $this->integer());
        $this->addColumn('{{%booking_trips}}', 'params_capacity', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_trips}}', 'params_duration');
        $this->dropColumn('{{%booking_trips}}', 'params_transfer');
        $this->dropColumn('{{%booking_trips}}', 'params_capacity');
    }

}
