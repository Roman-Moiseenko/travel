<?php

use yii\db\Migration;

/**
 * Class m210225_150553_add_booking_stays_nearby_unit_field
 */
class m210225_150553_add_booking_stays_nearby_unit_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_stays_nearby}}', 'unit', $this->string(2));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_stays_nearby}}', 'unit');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210225_150553_add_booking_stays_nearby_unit_field cannot be reverted.\n";

        return false;
    }
    */
}
