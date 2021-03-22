<?php

use yii\db\Migration;

/**
 * Class m210322_164631_del_booking_discount_table
 */
class m210322_164631_del_booking_discount_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('{{%booking_discount}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210322_164631_del_booking_discount_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210322_164631_del_booking_discount_table cannot be reverted.\n";

        return false;
    }
    */
}
