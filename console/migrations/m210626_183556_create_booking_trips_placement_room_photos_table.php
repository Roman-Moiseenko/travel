<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_trips_placement_room_photos}}`.
 */
class m210626_183556_create_booking_trips_placement_room_photos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_trips_placement_room_photos}}', [
            'id' => $this->primaryKey(),
            'room_id' => $this->integer()->notNull(),
            'file' => $this->string(),
            'sort' => $this->integer(),
            'alt' => $this->string(),
        ]);

        $this->createIndex('{{%idx-booking_trips_placement_room_photos-room_id}}', '{{%booking_trips_placement_room_photos}}', 'room_id');
        $this->addForeignKey(
            '{{%fk-booking_trips_placement_room_photos-room_id}}',
            '{{%booking_trips_placement_room_photos}}',
            'room_id',
            '{{%booking_trips_placement_room}}',
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
        $this->dropTable('{{%booking_trips_placement_room_photos}}');
    }
}
