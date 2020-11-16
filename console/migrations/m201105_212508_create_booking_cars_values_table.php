<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_cars_values}}`.
 */
class m201105_212508_create_booking_cars_values_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%booking_cars_values}}', [
            'car_id' => $this->integer()->notNull(),
            'characteristic_id' => $this->integer()->notNull(),
            'value' => $this->string(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-booking_cars_values}}', '{{%booking_cars_values}}', ['car_id', 'characteristic_id']);

        $this->createIndex('{{%idx-booking_cars_values-car_id}}', '{{%booking_cars_values}}', 'car_id');
        $this->createIndex('{{%idx-booking_cars_values-characteristic_id}}', '{{%booking_cars_values}}', 'characteristic_id');

        $this->addForeignKey('{{%fk-booking_cars_values-car_id}}', '{{%booking_cars_values}}', 'car_id', '{{%booking_cars}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-booking_cars_values-characteristic_id}}', '{{%booking_cars_values}}', 'characteristic_id', '{{%booking_cars_characteristics}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_cars_values}}');
    }
}
