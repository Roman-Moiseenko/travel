<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_wishlist_foods}}`.
 */
class m210401_081107_create_user_wishlist_foods_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_wishlist_foods}}', [
            'user_id' => $this->integer()->notNull(),
            'food_id' => $this->integer()->notNull(),
        ]);
        $this->addPrimaryKey('{{%pk-user_wishlist_foods}}', '{{%user_wishlist_foods}}', ['user_id', 'food_id']);

        $this->createIndex('{{%idx-user_wishlist_foods-user_id}}', '{{%user_wishlist_foods}}', 'user_id');
        $this->createIndex('{{%idx-user_wishlist_foods-food_id}}', '{{%user_wishlist_foods}}', 'food_id');

        $this->addForeignKey('{{%fk-user_wishlist_foods-user_id}}', '{{%user_wishlist_foods}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-user_wishlist_foods-food_id}}', '{{%user_wishlist_foods}}', 'food_id', '{{%foods}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_wishlist_foods}}');
    }
}
