<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shops_ad_product_material_assign}}`.
 */
class m210415_152117_create_shops_ad_product_material_assign_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shops_ad_product_material_assign}}', [
            'material_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
        ]);
        $this->addPrimaryKey('{{%pk-shops_ad_product_material_assign}}', '{{%shops_ad_product_material_assign}}', ['material_id', 'product_id']);
        $this->createIndex('{{%idx-shops_ad_product_material_assign-material_id}}', '{{%shops_ad_product_material_assign}}', 'material_id');
        $this->createIndex('{{%idx-shops_ad_product_material_assign-product_id}}', '{{%shops_ad_product_material_assign}}', 'product_id');

        $this->addForeignKey(
            '{{%fk-shops_ad_product_material_assign-material_id}}',
            '{{%shops_ad_product_material_assign}}',
            'material_id',
            '{{%shops_product_material}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
        $this->addForeignKey(
            '{{%fk-shops_ad_product_material_assign-product_id}}',
            '{{%shops_ad_product_material_assign}}',
            'product_id',
            '{{%shops_ad_product}}',
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
        $this->dropTable('{{%shops_ad_product_material_assign}}');
    }
}
