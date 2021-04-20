<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shops_cart_items}}`.
 */
class m210420_114345_create_shops_cart_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%shops_cart_items}}', [
            'id' => $this->bigPrimaryKey(),
            'user_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'quantity' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-shops_cart_items-user_id}}', '{{%shops_cart_items}}', 'user_id');
        $this->createIndex('{{%idx-shops_cart_items-product_id}}', '{{%shops_cart_items}}', 'product_id');

        $this->addForeignKey(
            '{{%fk-shops_cart_items-user_id}}',
            '{{%shops_cart_items}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            '{{%fk-shops_cart_items-product_id}}',
            '{{%shops_cart_items}}',
            'product_id',
            '{{%shops_product}}',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shops_cart_items}}');
    }
}
