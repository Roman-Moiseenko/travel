<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_trips_placement_meals_assign}}`.
 */
class m210625_191359_create_booking_trips_placement_meals_assign_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_trips_placement_meals_assign}}', [
            'placement_id' => $this->integer()->notNull(),
            'meal_id' => $this->integer()->notNull(),
            'cost' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('{{%pk-booking_trips_placement_meals_assign}}', '{{%booking_trips_placement_meals_assign}}', ['placement_id', 'meal_id']);

        $this->createIndex('{{%idx-booking_trips_placement_meals_assign-placement_id}}', '{{%booking_trips_placement_meals_assign}}', 'placement_id');
        $this->addForeignKey(
            '{{%idx-booking_trips_placement_meals_assign-placement_id}}',
            '{{%booking_trips_placement_meals_assign}}',
            'placement_id',
            '{{%booking_trips_placement}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
        $this->createIndex('{{%idx-booking_trips_placement_meals_assign-meal_id}}', '{{%booking_trips_placement_meals_assign}}', 'meal_id');
        $this->addForeignKey(
            '{{%idx-booking_trips_placement_meals_assign-meal_id}}',
            '{{%booking_trips_placement_meals_assign}}',
            'meal_id',
            '{{%booking_service_meal}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_trips_placement_meals_assign}}');
    }
}
