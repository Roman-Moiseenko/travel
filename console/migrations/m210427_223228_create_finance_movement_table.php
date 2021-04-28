<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%finance_movement}}`.
 */
class m210427_223228_create_finance_movement_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%finance_movement}}', [
            'id' => $this->primaryKey(),
            'legal_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'object_class' => $this->string(),
            'object_id' => $this->integer()->notNull(),
            'payment_id' => $this->string(),
            'amount' => $this->integer()->notNull(),
            'paid' => $this->boolean()->defaultValue(false),
        ]);

        $this->createIndex('{{%idx-finance_movement-legal_id}}','{{%finance_movement}}','legal_id');
        $this->createIndex('{{%idx-finance_movement-user_id}}','{{%finance_movement}}','user_id');
        $this->addForeignKey('{{%fk-finance_movement-legal_id}}',
            '{{%finance_movement}}',
            'legal_id',
            '{{%admin_user_legals}}',
            'id',
            'CASCADE',
            'RESTRICT'
            );
        $this->addForeignKey('{{%fk-finance_movement-user_id}}',
            '{{%finance_movement}}',
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
        $this->dropTable('{{%finance_movement}}');
    }
}
