<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_trips_placement_assign}}`.
 */
class m210624_213141_create_booking_trips_placement_assign_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_trips_placement_assign}}', [
            'trip_id' => $this->integer(),
            'placement_id' => $this->integer(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-booking_trips_placement_assign}}', '{{%booking_trips_placement_assign}}', ['trip_id', 'placement_id']);

        $this->createIndex('{{%idx-booking_trips_placement_assign-trip_id}}', '{{%booking_trips_placement_assign}}', 'trip_id');
        $this->createIndex('{{%idx-booking_trips_placement_assign-placement_id}}', '{{%booking_trips_placement_assign}}', 'placement_id');

        $this->addForeignKey('{{%fk-booking_trips_placement_assign-trip_id}}', '{{%booking_trips_placement_assign}}', 'trip_id', '{{%booking_trips}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-booking_trips_placement_assign-placement_id}}', '{{%booking_trips_placement_assign}}', 'placement_id', '{{%booking_trips_placement}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_trips_placement_assign}}');
    }
}
