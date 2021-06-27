<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_trips_placement_photos}}`.
 */
class m210623_224300_create_booking_trips_placement_photos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_trips_placement_photos}}', [
            'id' => $this->primaryKey(),
            'placement_id' => $this->integer()->notNull(),
            'file' => $this->string(),
            'sort' => $this->integer(),
            'alt' => $this->string(),
        ]);

        $this->createIndex('{{%idx-booking_trips_placement_photos-placement_id}}', '{{%booking_trips_placement_photos}}', 'placement_id');
        $this->addForeignKey(
            '{{%fk-booking_trips_placement_photos-placement_id}}',
            '{{%booking_trips_placement_photos}}',
            'placement_id',
            '{{%booking_trips_placement}}',
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
        $this->dropTable('{{%booking_trips_placement_photos}}');
    }
}
