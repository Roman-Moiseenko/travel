<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%admin_user_deposit}}`.
 */
class m210415_223827_create_admin_user_deposit_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%admin_user_deposit}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'amount' => $this->integer()->notNull(),
            'payment_id' => $this->string()->notNull(),
            'payment_status' => $this->boolean()->defaultValue(false),
        ]);

        $this->createIndex('{{%idx-admin_user_deposit-user_id}}', '{{%admin_user_deposit}}', 'user_id');
        $this->createIndex('{{%idx-admin_user_deposit-payment_id}}', '{{%admin_user_deposit}}', 'payment_id');

        $this->addForeignKey(
            '{{%idx-admin_user_deposit-user_id}}',
            '{{%admin_user_deposit}}',
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
        $this->dropTable('{{%admin_user_deposit}}');
    }
}
