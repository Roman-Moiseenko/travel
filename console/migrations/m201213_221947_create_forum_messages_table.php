<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%forum_messages}}`.
 */
class m201213_221947_create_forum_messages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%forum_messages}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'text' => $this->string(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer(),
            'sort' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-forum_messages-user_id}}', '{{%forum_messages}}', 'user_id');
        $this->createIndex('{{%idx-forum_messages-post_id}}', '{{%forum_messages}}', 'post_id');

        $this->addForeignKey('{{%fk-forum_messages-user_id}}', '{{%forum_messages}}', 'user_id', '{{%admin_users}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-forum_messages-post_id}}', '{{%forum_messages}}', 'post_id', '{{%forum_posts}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%forum_messages}}');
    }
}
