<?php

use yii\db\Migration;

/**
 * Class m210217_210142_add_booking_stay_rooms_assign_table
 */
class m210217_210142_add_booking_stay_rooms_assign_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_stay_rooms_assign}}', 'living', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_stay_rooms_assign}}', 'living');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210217_210142_add_booking_stay_rooms_assign_table cannot be reverted.\n";

        return false;
    }
    */
}
