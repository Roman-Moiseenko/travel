<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_wishlist_products}}`.
 */
class m210420_092427_create_user_wishlist_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%user_wishlist_products}}', [
            'user_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-user_wishlist_products}}', '{{%user_wishlist_products}}', ['user_id', 'product_id']);

        $this->createIndex('{{%idx-user_wishlist_products-user_id}}', '{{%user_wishlist_products}}', 'user_id');
        $this->createIndex('{{%idx-user_wishlist_products-product_id}}', '{{%user_wishlist_products}}', 'product_id');

        $this->addForeignKey('{{%fk-user_wishlist_products-user_id}}', '{{%user_wishlist_products}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-user_wishlist_products-product_id}}', '{{%user_wishlist_products}}', 'product_id', '{{%shops_product}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_wishlist_products}}');
    }
}
