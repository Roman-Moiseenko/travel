<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shops_delivery_company_assign}}`.
 */
class m210419_211940_create_shops_delivery_company_assign_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('{{%shops_delivery_company_assign}}');
        $this->createTable('{{%shops_delivery_company_assign}}', [
            'delivery_id' => $this->integer()->notNull(),
            'delivery_company_id' => $this->integer()->notNull(),
        ]);
        $this->addPrimaryKey('{{%pk-shops_delivery_company_assign}}', '{{%shops_delivery_company_assign}}', ['delivery_id', 'delivery_company_id']);
        $this->createIndex('{{%idx-shops_delivery_company_assign-delivery_id}}', '{{%shops_delivery_company_assign}}', 'delivery_id');
        $this->addForeignKey('{{%fk-shops_delivery_company_assign-delivery_id}}',
            '{{%shops_delivery_company_assign}}',
            'delivery_id',
            '{{%shops_delivery}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
        $this->createIndex('{{%idx-shops_delivery_company_assign-delivery_company_id}}', '{{%shops_delivery_company_assign}}', 'delivery_company_id');
        $this->addForeignKey('{{%fk-shops_delivery_company_assign-delivery_company_id}}',
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
