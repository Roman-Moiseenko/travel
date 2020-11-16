<?php

use yii\db\Migration;

/**
 * Class m201106_143746_add_booking_cars_address_json_field
 */
class m201106_143746_add_booking_cars_address_json_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_cars}}', 'address_json', 'JSON NOT NULL');
        $this->dropColumn('{{%booking_cars}}', 'address');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201106_143746_add_booking_cars_address_json_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201106_143746_add_booking_cars_address_json_field cannot be reverted.\n";

        return false;
    }
    */
}
