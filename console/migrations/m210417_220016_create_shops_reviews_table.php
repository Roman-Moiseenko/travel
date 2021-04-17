<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shops_reviews}}`.
 */
class m210417_220016_create_shops_reviews_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%shops_reviews}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer(),
            'shop_id' => $this->integer(),
            'user_id' => $this->integer(),
            'vote' => $this->integer(),
            'text' => $this->string(),
            'status' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('{{%idx-shops_reviews-shop_id}}', '{{%shops_reviews}}', 'shop_id');
        $this->createIndex('{{%idx-shops_reviews-user_id}}', '{{%shops_reviews}}', 'user_id');
        $this->addForeignKey(
            '{{%fk-shops_reviews-shop_id}}',
            '{{%shops_reviews}}',
            'shop_id',
            '{{%shops}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );

        $this->addForeignKey(
            '{{%fk-shops_reviews-user_id}}',
            '{{%shops_reviews}}',
            'user_id',
            '{{%users}}',
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
        $this->dropTable('{{%shops_reviews}}');
    }
}
