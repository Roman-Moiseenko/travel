<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shops_delivery_company_assign}}`.
 */
class m210408_143759_create_shops_delivery_company_assign_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shops_delivery_company_assign}}', [
            'shop_id' => $this->integer(),
            'delivery_company_id' => $this->integer(),
        ]);

        $this->addPrimaryKey('{{%pk-shops_delivery_company_assign}}', '{{%shops_delivery_company_assign}}', ['shop_id', 'delivery_company_id']);
        $this->createIndex('{{%idx-shops_delivery_company_assign-shop_id}}', '{{%shops_delivery_company_assign}}', 'shop_id');
        $this->createIndex('{{%idx-shops_delivery_company_assign-delivery_company_id}}', '{{%shops_delivery_company_assign}}', 'delivery_company_id');

        $this->addForeignKey(
            '{{%fk-shops_delivery_company_assign-shop_id}}',
            '{{%shops_delivery_company_assign}}',
            'shop_id',
            '{{%shops}}',
            'id',
            'CASCADE',
            'RESTRICT'
            );
        $this->addForeignKey(
            '{{%fk-shops_delivery_company_assign-delivery_company_id}}',
            '{{%shops_delivery_company_assign}}',
            'delivery_company_id',
            '{{%shops_delivery_company}}',
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
        $this->dropTable('{{%shops_delivery_company_assign}}');
    }
}
