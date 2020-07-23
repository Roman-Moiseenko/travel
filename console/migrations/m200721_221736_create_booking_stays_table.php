<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_stays}}`.
 */
class m200721_221736_create_booking_stays_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_stays}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'legal_id'=> $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'name' => $this->string(),
            'status' => $this->integer(),
            'stars' => $this->integer()->defaultValue(0),
            'rating' => $this->decimal(3, 2),
            'main_photo_id' => $this->integer(),
            'type' => $this->integer(),
            'adr_town' => $this->string(),
            'adr_street' => $this->string(),
            'adr_house' => $this->string(),
            'geo_latitude' => $this->string(),
            'geo_longitude' => $this->string(),
        ]);
        $this->createIndex('{{%idx-booking_stays-main_photo_id}}', '{{%booking_stays}}', 'main_photo_id');
        $this->addForeignKey('{{%fk-booking_stays-main_photo_id}}', '{{%booking_stays}}', 'main_photo_id', '{{%booking_stays_photos}}', 'id', 'SET NULL', 'RESTRICT');
        $this->addForeignKey('{{%fk-booking_stays-type}}', '{{%booking_stays}}', 'type', '{{%booking_stays_type}}', 'id', 'SET NULL', 'RESTRICT');
        $this->addForeignKey('{{%fk-booking_stays-legal_id}}', '{{%booking_stays}}', 'legal_id', '{{%admin_users_legal}}', 'id', 'SET NULL', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_stays}}');
    }
}
