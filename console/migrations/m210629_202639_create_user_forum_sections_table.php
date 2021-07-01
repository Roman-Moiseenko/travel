<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_forum_sections}}`.
 */
class m210629_202639_create_user_forum_sections_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_forum_sections}}', [
            'id' => $this->primaryKey(),
            'caption' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'sort' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_forum_sections}}');
    }
}
