<?php

use yii\db\Migration;

/**
 * Class m201115_151133_add_booking_cars_name_userid_index
 */
class m201115_151133_add_booking_cars_name_userid_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('{{%idx-booking_cars-user_id-name}}', '{{%booking_cars}}', ['user_id', 'name'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('{{%idx-booking_cars-user_id-name}}', '{{%booking_cars}}');
    }

}
