<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%admin_user_debiting}}`.
 */
class m210416_072104_create_admin_user_debiting_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%admin_user_debiting}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'amount' => $this->integer()->notNull(),
            'type' => $this->integer()->notNull(),
            'link' => $this->string(),
        ]);

        $this->createIndex('{{%idx-admin_user_debiting-user_id}}', '{{%admin_user_debiting}}', 'user_id');

        $this->addForeignKey(
            '{{%idx-admin_user_debiting-user_id}}',
            '{{%admin_user_debiting}}',
            'user_id',
            '{{%admin_users}}',
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
        $this->dropTable('{{%admin_user_debiting}}');
    }
}
