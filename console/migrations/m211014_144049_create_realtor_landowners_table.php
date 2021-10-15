<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%realtor_landowners}}`.
 */
class m211014_144049_create_realtor_landowners_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%realtor_landowners}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(), //Название территории
            'slug' => $this->string(),
            'status' => $this->integer(),
            'created_at' => $this->integer(),
            //Владелец
            'caption' => $this->string(), //Название
            'phone' => $this->string(), // ..
            'email' => $this->string(), // ..

            'cost' => $this->integer(),
            'description' => $this->text(),
            'count' => $this->string(),
            'distance' => $this->decimal(5, 1),
            'size' => $this->integer(),

            'text' => 'MEDIUMTEXT',
            'main_photo_id' => $this->integer(),
            'address_address' => $this->string(),
            'address_latitude' => $this->string(),
            'address_longitude' => $this->string(),
            'meta_json' => 'JSON NOT NULL',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%realtor_landowners}}');
    }
}
