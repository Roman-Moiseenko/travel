<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shops_product_photos}}`.
 */
class m210408_094121_create_shops_product_photos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shops_product_photos}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'file' => $this->string(),
            'sort' => $this->integer(),
            'alt' => $this->string(),
        ]);

        $this->createIndex('{{%idx-shops_product_photos-product_id}}', '{{%shops_product_photos}}', 'product_id');
        $this->addForeignKey(
            '{{%fk-shops_product_photos-product_id}}',
            '{{%shops_product_photos}}',
            'product_id',
            '{{%shops_product}}',
            'id',
            'CASCADE',
            'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shops_product_photos}}');
    }
}
