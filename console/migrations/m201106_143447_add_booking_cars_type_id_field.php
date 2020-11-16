<?php

use yii\db\Migration;

/**
 * Class m201106_143447_add_booking_cars_type_id_field
 */
class m201106_143447_add_booking_cars_type_id_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_cars}}', 'type_id', $this->integer());
        $this->createIndex('{{%idx-booking_cars-type_id}}', '{{%booking_cars}}', 'type_id');
        $this->addForeignKey('{{%fk-booking_cars-type_id}}', '{{%booking_cars}}', 'type_id', '{{%booking_cars_type}}', 'id', 'SET NULL', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_cars}}', 'type_id');
    }

}
