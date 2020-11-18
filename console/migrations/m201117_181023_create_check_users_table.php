<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%check_users}}`.
 */
class m201117_181023_create_check_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%check_users}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

            'admin_id' => $this->integer()->notNull(),
            'fullname' => $this->string(120),
            'box_office' => $this->string(120),
            'phone' => $this->string(16),
        ], $tableOptions);

        $this->createIndex('{{%idx-check_users-username}}', '{{%check_users}}', 'username');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%check_users}}');
    }
}
