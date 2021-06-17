<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_trips_photos}}`.
 */
class m210616_203839_create_booking_trips_photos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_trips_photos}}', [
            'id' => $this->primaryKey(),
            'trip_id' => $this->integer()->notNull(),
            'file' => $this->string(),
            'sort' => $this->integer(),
            'alt' => $this->string(),
        ]);

        $this->createIndex('{{%idx-booking_trips_photos-trip_id}}', '{{%booking_trips_photos}}', 'trip_id');
        $this->addForeignKey(
            '{{%fk-booking_trips_photos-trip_id}}',
            '{{%booking_trips_photos}}',
            'trip_id',
            '{{%booking_trips}}',
            'id',
            'CASCADE',
            'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_trips_photos}}');
    }
}
