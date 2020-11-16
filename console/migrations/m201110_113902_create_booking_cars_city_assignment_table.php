<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_cars_city_assignment}}`.
 */
class m201110_113902_create_booking_cars_city_assignment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_cars_city_assignment}}', [
            'car_id' => $this->integer()->notNull(),
            'city_id' => $this->integer()->notNull()
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-booking_cars_city_assignment}}', '{{%booking_cars_city_assignment}}', ['car_id', 'city_id']);

        $this->createIndex('{{%idx-booking_cars_city_assignment-car_id}}', '{{%booking_cars_city_assignment}}', 'car_id');
        $this->createIndex('{{%idx-booking_cars_city_assignment-city_id}}', '{{%booking_cars_city_assignment}}', 'city_id');

        $this->addForeignKey('{{%fk-booking_cars_city_assignment-car_id}}', '{{%booking_cars_city_assignment}}', 'car_id', '{{%booking_cars}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-booking_cars_city_assignment-city_id}}', '{{%booking_cars_city_assignment}}', 'city_id', '{{%booking_service_city}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_cars_city_assignment}}');
    }
}
