<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_wishlist_funs}}`.
 */
class m201207_201827_create_user_wishlist_funs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%user_wishlist_funs}}', [
            'user_id' => $this->integer()->notNull(),
            'fun_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-user_wishlist_funs}}', '{{%user_wishlist_funs}}', ['user_id', 'fun_id']);

        $this->createIndex('{{%idx-user_wishlist_funs-user_id}}', '{{%user_wishlist_funs}}', 'user_id');
        $this->createIndex('{{%idx-user_wishlist_funs-fun_id}}', '{{%user_wishlist_funs}}', 'fun_id');

        $this->addForeignKey('{{%fk-user_wishlist_funs-user_id}}', '{{%user_wishlist_funs}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-user_wishlist_funs-fun_id}}', '{{%user_wishlist_funs}}', 'fun_id', '{{%booking_funs}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_wishlist_funs}}');
    }
}
