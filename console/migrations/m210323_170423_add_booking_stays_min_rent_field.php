<?php

use yii\db\Migration;

/**
 * Class m210323_170423_add_booking_stays_min_rent_field
 */
class m210323_170423_add_booking_stays_min_rent_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_stays}}', 'min_rent', $this->integer()->defaultValue(1));
        $this->update('{{%booking_stays}}', ['min_rent' => 1]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_stays}}', 'min_rent');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210323_170423_add_booking_stays_min_rent_field cannot be reverted.\n";

        return false;
    }
    */
}
