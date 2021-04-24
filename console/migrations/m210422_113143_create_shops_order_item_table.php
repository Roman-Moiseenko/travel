<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shops_order_item}}`.
 */
class m210422_113143_create_shops_order_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%shops_order_item}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'quantity' => $this->integer()->notNull(),
            'product_cost' => $this->integer()->notNull(),
            'product_name' => $this->string()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-shops_order_item-order_id}}', '{{%shops_order_item}}', 'order_id');
        $this->createIndex('{{%idx-shops_order_item-product_id}}', '{{%shops_order_item}}', 'product_id');

        $this->addForeignKey(
            '{{%fk-shops_order_item-order_id}}',
            '{{%shops_order_item}}',
            'order_id',
            '{{%shops_order}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
        $this->addForeignKey(
            '{{%fk-shops_order_item-product_id}}',
            '{{%shops_order_item}}',
            'product_id',
            '{{%shops_product}}',
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
        $this->dropTable('{{%shops_order_item}}');
    }
}
