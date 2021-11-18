<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%art_event_category}}`.
 */
class m211116_183908_create_art_event_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%art_event_category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string(),
            'icon' => $this->string(),
            'sort' => $this->integer(),
            'meta_json' => 'JSON NOT NULL',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%art_event_category}}');
    }
}
