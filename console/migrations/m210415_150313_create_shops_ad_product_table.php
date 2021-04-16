<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shops_ad_product}}`.
 */
class m210415_150313_create_shops_ad_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%shops_ad_product}}', [
            'id' => $this->primaryKey(),
            'shop_id' => $this->integer()->notNull(),
            'name' => $this->string(),
            'description' => $this->text(),
            'name_en' => $this->string(),
            'description_en' => $this->text(),
            'created_at' => $this->integer(),
            'weight' => $this->integer(),
            'article' => $this->string(),
            'collection' => $this->string(),
            'color' => $this->string(),
            'cost' => $this->integer(),
            'discount' => $this->integer(),
            'manufactured_id' => $this->integer(),
            'category_id' => $this->integer(),
            'active' => $this->boolean(),
            'size_json' => 'JSON NOT NULL',
            'main_photo_id' => $this->integer(),
            'meta_json' => 'JSON NOT NULL',
        ], $tableOptions);
        $this->createIndex('{{%idx-shops_ad_product-shop_id}}', '{{%shops_ad_product}}', 'shop_id');
        $this->createIndex('{{%idx-shops_ad_product-manufactured_id}}', '{{%shops_ad_product}}', 'manufactured_id');
        $this->createIndex('{{%idx-shops_ad_product-category_id}}', '{{%shops_ad_product}}', 'category_id');

        $this->addForeignKey(
            '{{%fk-shops_ad_product-shop_id}}',
            '{{%shops_ad_product}}',
            'shop_id',
            '{{%shops_ad}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );

        $this->addForeignKey(
            '{{%fk-shops_ad_product-category_id}}',
            '{{%shops_ad_product}}',
            'category_id',
            '{{%shops_product_category}}',
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
        $this->dropTable('{{%shops_ad_product}}');
    }
}
