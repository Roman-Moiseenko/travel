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
            'baseprice' => $this->integer(),
            'count' => $this->integer(),
            'capacity' => $this->integer(),
            'square' => $this->integer(),
            'subrooms' => $this->integer(), //Кол-во комнат в номере
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_rooms}}');
    }
}
