<?php

use yii\db\Migration;

/**
 * Class m201222_135710_drop_booking_funs_calendar_booking_calendar_id_field
 */
class m201222_135710_drop_booking_funs_calendar_booking_calendar_id_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%booking_funs_calendar_booking}}', 'calendar_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%booking_funs_calendar_booking}}', 'calendar_id', $this->integer()->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201222_135710_drop_booking_funs_calendar_booking_calendar_id_field cannot be reverted.\n";

        return false;
    }
    */
}
