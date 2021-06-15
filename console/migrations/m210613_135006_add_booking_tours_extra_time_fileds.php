<?php

use yii\db\Migration;

/**
 * Class m210613_135006_add_booking_tours_extra_time_fileds
 */
class m210613_135006_add_booking_tours_extra_time_fileds extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_tours}}', 'extra_time_cost', $this->integer());
        $this->addColumn('{{%booking_tours}}', 'extra_time_max', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_tours}}', 'extra_time_cost');
        $this->dropColumn('{{%booking_tours}}', 'extra_time_max');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210613_135006_add_booking_tours_extra_time_fileds cannot be reverted.\n";

        return false;
    }
    */
}
