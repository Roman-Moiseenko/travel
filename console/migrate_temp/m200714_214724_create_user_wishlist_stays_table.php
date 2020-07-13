<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_wishlist_items}}`.
 */
class m200714_214724_create_user_wishlist_stays_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%user_wishlist_stays}}', [
            'user_id' => $this->integer()->notNull(),
            'booking_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-user_wishlist_stays}}', '{{%user_wishlist_stays}}', ['user_id', 'booking_id']);

        $this->createIndex('{{%idx-user_wishlist_stays-user_id}}', '{{%user_wishlist_stays}}', 'user_id');
        $this->createIndex('{{%idx-user_wishlist_stays-booking_id}}', '{{%user_wishlist_stays}}', 'booking_id');

        $this->addForeignKey('{{%fk-user_wishlist_stays-user_id}}', '{{%user_wishlist_stays}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-user_wishlist_stays-booking_id}}', '{{%user_wishlist_stays}}', 'booking_id', '{{%booking_facility}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_wishlist_items}}');
    }
}
