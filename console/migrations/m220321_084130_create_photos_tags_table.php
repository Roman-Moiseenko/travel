<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%photos_tags}}`.
 */
class m220321_084130_create_photos_tags_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%photos_tags}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->unique(),
            'slug' => $this->string()->unique(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%photos_tags}}');
    }
}
