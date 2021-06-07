<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vmuseum}}`.
 */
class m210603_184032_create_vmuseum_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%vmuseum}}', [
            'id' => $this->primaryKey(),
            'fun_id' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer(),
            'status' => $this->integer()->notNull(),
            'name' => $this->string(),
            'name_en' => $this->string(),
            'description' => $this->text(),
            'description_en' => $this->text(),
            'slug' => $this->string(),
            'rating' => $this->decimal(5, 2),
            'main_photo_id' => $this->integer(),

            'meta_json' => 'JSON NOT NULL',
            'work_mode_json' => 'JSON NOT NULL',
            'address_address' => $this->string(),
            'address_latitude' => $this->string(),
            'address_longitude' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%vmuseum}}');
    }
}
