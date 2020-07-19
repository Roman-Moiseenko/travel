<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%office_users}}`.
 */
class m200719_190509_create_office_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%office_users}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'verification_token' => $this->string()->defaultValue(null),
        ], null);

        $this->createIndex('{{%idx-office_users-username}}', '{{%office_users}}', 'username');
        $this->createIndex('{{%idx-office_users-email}}', '{{%office_users}}', 'email');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%office_users}}');
    }
}
