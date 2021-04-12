<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog_maps}}`.
 */
class m210411_212602_create_blog_maps_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%blog_maps}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%blog_maps}}');
    }
}
