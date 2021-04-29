<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shops_category_assign}}`.
 */
class m210429_073507_create_shops_category_assign_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shops_category_assign}}', [
            'shop_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
        ]);
        $this->addPrimaryKey('{{%pk-shops_category_assign}}', '{{%shops_category_assign}}', ['shop_id', 'category_id']);
        $this->createIndex('{{%idx-shops_category_assign-shop_id}}', '{{%shops_category_assign}}', 'shop_id');
        $this->addForeignKey('{{%fk-shops_category_assign-shop_id}}',
            '{{%shops_category_assign}}',
            'shop_id',
            '{{%shops}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
        $this->createIndex('{{%idx-shops_category_assign-category_id}}', '{{%shops_category_assign}}', 'category_id');
        $this->addForeignKey('{{%fk-shops_category_assign-category_id}}',
            '{{%shops_category_assign}}',
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
        $this->dropTable('{{%shops_category_assign}}');
    }
}
