<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_trips_activity}}`.
 */
class m210628_223201_create_booking_trips_activity_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%booking_trips_activity}}', [
            'id' => $this->primaryKey(),
            'trip_id' => $this->integer()->notNull(),
            'day' => $this->integer()->notNull(),
            'cost' => $this->integer()->defaultValue(0),
            'main_photo_id' => $this->integer(),
            'time' => $this->string(),
            'caption' => $this->string(),
            'caption_en' => $this->string(),
            'description' => $this->text(),
            'description_en' => $this->text(),
            'address_address' => $this->string(),
            'address_latitude' => $this->string(),
            'address_longitude' => $this->string(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_trips_activity}}');
    }
}
