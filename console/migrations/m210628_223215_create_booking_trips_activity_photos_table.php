<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_trips_activity_photos}}`.
 */
class m210628_223215_create_booking_trips_activity_photos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_trips_activity_photos}}', [
            'id' => $this->primaryKey(),
            'activity_id' => $this->integer()->notNull(),
            'file' => $this->string(),
            'sort' => $this->integer(),
            'alt' => $this->string(),
        ]);

        $this->createIndex('{{%idx-booking_trips_activity_photos-activity_id}}', '{{%booking_trips_activity_photos}}', 'activity_id');
        $this->addForeignKey(
            '{{%fk-booking_trips_activity_photos-activity_id}}',
            '{{%booking_trips_activity_photos}}',
            'activity_id',
            '{{%booking_trips_activity}}',
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
        $this->dropTable('{{%booking_trips_activity_photos}}');
    }
}
