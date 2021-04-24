<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shops_order_status}}`.
 */
class m210422_113206_create_shops_order_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%shops_order_status}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'comment' => $this->string(),
        ], $tableOptions);

        $this->createIndex('{{%idx-shops_order_status-order_id}}', '{{%shops_order_status}}', 'order_id');
        $this->createIndex('{{%idx-shops_order_status-order_id-status}}', '{{%shops_order_status}}', ['order_id', 'status'], true);
        $this->addForeignKey(
            '{{%fk-shops_order_status-order_id}}',
            '{{%shops_order_status}}',
            'order_id',
            '{{%shops_order}}',
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
        $this->dropTable('{{%shops_order_status}}');
    }
}
