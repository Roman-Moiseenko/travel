<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%forum_posts}}`.
 */
class m201213_221258_create_forum_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%forum_posts}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'caption' => $this->string(),
            'created_at' => $this->integer()->notNull(),
            'update_at' => $this->integer(),
            'count' => $this->integer()->notNull(),
            'last_sort' => $this->integer(),
            'status' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%forum_posts}}');
    }
}
