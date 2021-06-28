<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_trips_placement_room_comfort_assign}}`.
 */
class m210626_182650_create_booking_trips_placement_room_comfort_assign_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_trips_placement_room_comfort_assign}}', [
            'room_id' => $this->integer(),
            'comfort_id' => $this->integer(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-booking_trips_placement_room_comfort_assign}}', '{{%booking_trips_placement_room_comfort_assign}}', ['room_id', 'comfort_id']);

        $this->createIndex('{{%idx-booking_trips_placement_room_comfort_assign-room_id}}', '{{%booking_trips_placement_room_comfort_assign}}', 'room_id');
        $this->createIndex('{{%idx-booking_trips_placement_room_comfort_assign-comfort_id}}', '{{%booking_trips_placement_room_comfort_assign}}', 'comfort_id');

        $this->addForeignKey('{{%fk-booking_trips_placement_room_comfort_assign-room_id}}', '{{%booking_trips_placement_room_comfort_assign}}', 'room_id', '{{%booking_trips_placement_room}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-booking_trips_placement_room_comfort_assign-comfort_id}}', '{{%booking_trips_placement_room_comfort_assign}}', 'comfort_id', '{{%booking_stays_comfort_room}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_trips_placement_room_comfort_assign}}');
    }
}
