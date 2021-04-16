<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shops_ad_product_photos}}`.
 */
class m210415_150350_create_shops_ad_product_photos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shops_ad_product_photos}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'file' => $this->string(),
            'sort' => $this->integer(),
            'alt' => $this->string(),
        ]);

        $this->createIndex('{{%idx-shops_ad_product_photos-product_id}}', '{{%shops_ad_product_photos}}', 'product_id');
        $this->addForeignKey(
            '{{%fk-shops_ad_product_photos-product_id}}',
            '{{%shops_ad_product_photos}}',
            'product_id',
            '{{%shops_ad_product}}',
            'id',
            'CASCADE',
            'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shops_ad_product_photos}}');
    }
}
