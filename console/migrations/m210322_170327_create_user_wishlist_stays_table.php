<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_wishlist_stays}}`.
 */
class m210322_170327_create_user_wishlist_stays_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_wishlist_stays}}', [
            'user_id' => $this->integer()->notNull(),
            'stay_id' => $this->integer()->notNull(),
        ]);
        $this->addPrimaryKey('{{%pk-user_wishlist_stays}}', '{{%user_wishlist_stays}}', ['user_id', 'stay_id']);

        $this->createIndex('{{%idx-user_wishlist_stays-user_id}}', '{{%user_wishlist_stays}}', 'user_id');
        $this->createIndex('{{%idx-user_wishlist_stays-stay_id}}', '{{%user_wishlist_stays}}', 'stay_id');

        $this->addForeignKey('{{%fk-user_wishlist_stays-user_id}}', '{{%user_wishlist_stays}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-user_wishlist_stays-stay_id}}', '{{%user_wishlist_stays}}', 'stay_id', '{{%booking_stays}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_wishlist_stays}}');
    }
}
