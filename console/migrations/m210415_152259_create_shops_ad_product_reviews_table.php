<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shops_ad_product_reviews}}`.
 */
class m210415_152259_create_shops_ad_product_reviews_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%shops_ad_product_reviews}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer(),
            'product_id' => $this->integer(),
            'user_id' => $this->integer(),
            'vote' => $this->integer(),
            'text' => $this->string(),
            'status' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('{{%idx-shops_ad_product_reviews-product_id}}', '{{%shops_ad_product_reviews}}', 'product_id');
        $this->createIndex('{{%idx-shops_ad_product_reviews-user_id}}', '{{%shops_ad_product_reviews}}', 'user_id');
        $this->addForeignKey(
            '{{%fk-shops_ad_product_reviews-product_id}}',
            '{{%shops_ad_product_reviews}}',
            'product_id',
            '{{%shops_ad_product}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );

        $this->addForeignKey(
            '{{%fk-shops_ad_product_reviews-user_id}}',
            '{{%shops_ad_product_reviews}}',
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
        $this->dropTable('{{%shops_ad_product_reviews}}');
    }
}
