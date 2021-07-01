<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_forum_read}}`.
 */
class m210630_212928_create_user_forum_read_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%user_forum_read}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'post_id' => $this->integer()->notNull(),
            'last_at' => $this->integer()->notNull()
        ], $tableOptions);

        $this->createIndex('{{%idx-user_forum_read-user_id}}', '{{%user_forum_read}}', 'user_id');
        $this->addForeignKey(
            '{{%fk-user_forum_read-user_id}}',
            '{{%user_forum_read}}',
            'user_id',
            '{{%users}}',
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
        $this->dropTable('{{%user_forum_read}}');
    }
}
