<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_cars_calendar_cost}}`.
 */
class m201109_105256_create_booking_cars_calendar_cost_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_cars_calendar_cost}}', [
            'id' => $this->primaryKey(),
            'car_id' => $this->integer(),
            'car_at' => $this->integer(),
            'cost' => $this->integer(),
            'count' => $this->integer(),
            'status' => $this->integer(),
        ], $tableOptions);
        $this->createIndex('{{%idx-booking_cars_calendar_cost-car_id}}', '{{%booking_cars_calendar_cost}}','car_id');
        $this->createIndex('{{%idx-booking_cars_calendar_cost-unique}}',
            '{{%booking_cars_calendar_cost}}',
            ['car_id', 'car_at'], true);
        $this->addForeignKey('{{%fk-booking_cars_calendar_cost-car_id}}', '{{%booking_cars_calendar_cost}}', 'car_id', '{{%booking_cars}}', 'id', 'SET NULL', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_cars_calendar_cost}}');
    }
}
