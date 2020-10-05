<?php

use yii\db\Migration;

/**
 * Class m201005_202444_add_booking_tours_calendar_booking_field
 */
class m201005_202444_add_booking_tours_calendar_booking_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_tours_calendar_booking}}', 'unload', $this->boolean());
        $this->update('{{%booking_tours_calendar_booking}}', ['unload' => false]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_tours_calendar_booking}}', 'unload');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201005_202444_add_booking_tours_calendar_booking_field cannot be reverted.\n";

        return false;
    }
    */
}
