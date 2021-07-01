<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_forum_posts}}`.
 */
class m210630_212510_create_user_forum_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%user_forum_posts}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'caption' => $this->string(),
            'created_at' => $this->integer()->notNull(),
            'update_at' => $this->integer(),
            'count' => $this->integer()->notNull(),
            'last_sort' => $this->integer(),
            'status' => $this->integer()->notNull(),
            'fix' => $this->boolean()->defaultValue(false),
        ], $tableOptions);

        $this->createIndex('{{%idx-user_forum_posts-category_id}}', '{{%user_forum_posts}}', 'category_id');
        $this->addForeignKey(
            '{{%fk-user_forum_posts-category_id}}',
            '{{%user_forum_posts}}',
            'category_id',
            '{{%user_forum_categories}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_forum_posts}}');
    }
}
