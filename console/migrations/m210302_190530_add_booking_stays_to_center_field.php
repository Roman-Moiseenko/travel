<?php

use yii\db\Migration;

/**
 * Class m210302_190530_add_booking_stays_to_center_field
 */
class m210302_190530_add_booking_stays_to_center_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_stays}}', 'to_center', $this->integer()->defaultValue(0));
        $this->update('{{%booking_stays}}', ['to_center' => 0]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210302_190530_add_booking_stays_to_center_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210302_190530_add_booking_stays_to_center_field cannot be reverted.\n";

        return false;
    }
    */
}
