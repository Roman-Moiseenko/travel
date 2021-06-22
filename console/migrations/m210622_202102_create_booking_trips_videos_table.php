<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_trips_videos}}`.
 */
class m210622_202102_create_booking_trips_videos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_trips_videos}}', [
            'id' => $this->primaryKey(),
            'trip_id' => $this->integer()->notNull(),
            'caption' => $this->string(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer(),
            'url' => $this->string(),
            'type_hosting' => $this->integer(),
            'sort' => $this->integer(),
        ]);

        $this->createIndex('{{%idx-booking_trips_videos-trip_id}}', '{{%booking_trips_videos}}', 'trip_id');
        $this->addForeignKey(
            '{{%idx-booking_trips_videos-trip_id}}',
            '{{%booking_trips_videos}}',
            'trip_id',
            '{{%booking_trips}}',
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
        $this->dropTable('{{%booking_trips_videos}}');
    }
}
