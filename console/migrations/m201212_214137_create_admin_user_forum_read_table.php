<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%admin_user_forum_read}}`.
 */
class m201212_214137_create_admin_user_forum_read_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%admin_user_forum_read}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'post_id' => $this->integer()->notNull(),
            'last_id' => $this->integer()->notNull()
        ], $tableOptions);

        $this->createIndex('{{%idx-admin_user_forum_read-user_id}}', '{{%admin_user_forum_read}}', 'user_id');
        $this->addForeignKey('{{%fk-admin_user_forum_read-user_id}}', '{{%admin_user_forum_read}}', 'user_id', '{{%admin_users}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%admin_user_forum_read}}');
    }
}
