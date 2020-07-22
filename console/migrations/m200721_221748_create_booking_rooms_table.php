<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_rooms}}`.
 */
class m200721_221748_create_booking_rooms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_rooms}}', [
            'id' => $this->primaryKey(),
            'stays_id' => $this->integer(),
            'name' => $this->string(),
            'baseprice' => $this->integer(), //Базовая цена
            'count' => $this->integer(), //Кол-во таких номеров в отеле
            'capacity' => $this->integer(), //Вместимость
            'square' => $this->integer(), //Площадь
            'subrooms' => $this->integer(), //Кол-во комнат в номере
            'type' => $this->integer(),
            'main_photo_id' => $this->integer(),
        ]);

        $this->createIndex('{{%idx-booking_rooms-main_photo_id}}', '{{%booking_rooms}}', 'main_photo_id');
        $this->addForeignKey('{{%fk-booking_rooms-main_photo_id}}', '{{%booking_rooms}}', 'main_photo_id',
            '{{%booking_rooms_photos}}', 'id', 'SET NULL', 'RESTRICT');
        $this->addForeignKey('{{%fk-booking_rooms-type}}', '{{%booking_rooms}}', 'type',
            '{{%booking_rooms_type}}', 'id', 'SET NULL', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_rooms}}');
    }
}
