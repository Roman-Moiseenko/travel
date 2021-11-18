<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%art_event}}`.
 */
class m211117_125850_create_art_event_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%art_event}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(),
            'name' => $this->string(),
            'slug' => $this->string(),
            'created_at' => $this->string(),
            'updated_at' => $this->string(),
            'title' => $this->string(),
            'description' => $this->text(),
            'content' => 'MEDIUMTEXT',
            'video' => $this->string(),
            'photo' => $this->string(),
            'status' => $this->integer(),
            'cost' => $this->integer(),

            'contact_phone' => $this->string(),
            'contact_url' => $this->string(),
            'contact_email' => $this->string(),
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
        $this->dropTable('{{%art_event}}');
    }
}
