<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_rooms_photos}}`.
 */
class m200721_221805_create_booking_rooms_photos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%booking_rooms_photos}}', [
            'id' => $this->primaryKey(),
            'rooms_id' => $this->integer()->notNull(),
            'file' => $this->string()->notNull(),
            'sort' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-booking_rooms_photos-stays_id}}', '{{%booking_rooms_photos}}', 'rooms_id');
        $this->addForeignKey('{{%fk-booking_rooms_photos-stays_id}}', '{{%booking_rooms_photos}}', 'rooms_id', '{{%booking_rooms}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_rooms_photos}}');
    }
}
