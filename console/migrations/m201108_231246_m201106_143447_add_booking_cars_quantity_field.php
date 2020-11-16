<?php

use yii\db\Migration;

/**
 * Class m201108_231246_m201106_143447_add_booking_cars_quantity_field
 */
class m201108_231246_m201106_143447_add_booking_cars_quantity_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_cars}}', 'quantity', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_cars}}', 'quantity');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201108_231246_m201106_143447_add_booking_cars_quantity_field cannot be reverted.\n";

        return false;
    }
    */
}
