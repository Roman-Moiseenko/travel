<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_forum_messages}}`.
 */
class m210630_212713_create_user_forum_messages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%user_forum_messages}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'text' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer(),
            'sort' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-user_forum_messages-user_id}}', '{{%user_forum_messages}}', 'user_id');
        $this->createIndex('{{%idx-user_forum_messages-post_id}}', '{{%user_forum_messages}}', 'post_id');

        $this->addForeignKey(
            '{{%fk-user_forum_messages-user_id}}',
            '{{%user_forum_messages}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
        $this->addForeignKey(
            '{{%fk-user_forum_messages-post_id}}',
            '{{%user_forum_messages}}',
            'post_id',
            '{{%user_forum_posts}}',
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
        $this->dropTable('{{%user_forum_messages}}');
    }
}
