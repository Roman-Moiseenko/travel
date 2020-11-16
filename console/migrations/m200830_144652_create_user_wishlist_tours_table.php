<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_tours_wishlist}}`.
 */
class m200830_144652_create_user_wishlist_tours_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_wishlist_tours}}', [
            'user_id' => $this->integer()->notNull(),
            'tour_id' => $this->integer()->notNull(),
        ]);
        $this->addPrimaryKey('{{%pk-user_wishlist_tours}}', '{{%user_wishlist_tours}}', ['user_id', 'tour_id']);

        $this->createIndex('{{%idx-user_wishlist_tours-user_id}}', '{{%user_wishlist_tours}}', 'user_id');
        $this->createIndex('{{%idx-user_wishlist_tours-tour_id}}', '{{%user_wishlist_tours}}', 'tour_id');

        $this->addForeignKey('{{%fk-user_wishlist_tours-user_id}}', '{{%user_wishlist_tours}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-user_wishlist_tours-tour_id}}', '{{%user_wishlist_tours}}', 'tour_id', '{{%booking_tours}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_tours_wishlist}}');
    }
}
