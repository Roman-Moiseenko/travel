<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%photos_page}}`.
 */
class m220321_100427_create_photos_page_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%photos_page}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'title' => $this->string(),
            'slug' => $this->string(),
            'description' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'public_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'status' => $this->integer()->notNull(),

            'meta_json' => 'JSON NOT NULL',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%photos_page}}');
    }
}
