<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_wishlist_cars}}`.
 */
class m201106_141944_create_user_wishlist_cars_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%user_wishlist_cars}}', [
            'user_id' => $this->integer()->notNull(),
            'car_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-user_wishlist_cars}}', '{{%user_wishlist_cars}}', ['user_id', 'car_id']);

        $this->createIndex('{{%idx-user_wishlist_cars-user_id}}', '{{%user_wishlist_cars}}', 'user_id');
        $this->createIndex('{{%idx-user_wishlist_cars-car_id}}', '{{%user_wishlist_cars}}', 'car_id');

        $this->addForeignKey('{{%fk-user_wishlist_cars-user_id}}', '{{%user_wishlist_cars}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-user_wishlist_cars-car_id}}', '{{%user_wishlist_cars}}', 'car_id', '{{%booking_cars}}', 'id', 'CASCADE', 'RESTRICT');


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_wishlist_cars}}');
    }
}
