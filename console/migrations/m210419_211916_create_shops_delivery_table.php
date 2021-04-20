<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shops_delivery}}`.
 */
class m210419_211916_create_shops_delivery_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shops_delivery}}', [
            'id' => $this->primaryKey(),
            'shop_id' => $this->integer(),
            'onCity' => $this->boolean()->defaultValue(false),
            'costCity' => $this->integer()->defaultValue(0),
            'minAmountCity' => $this->integer()->defaultValue(0),
            'minAmountCompany' => $this->integer()->defaultValue(0),
            'period' => $this->integer()->defaultValue(0),
            'onPoint' => $this->boolean()->defaultValue(false),
            'address' => $this->string(),
            'latitude' => $this->string(),
            'longitude' => $this->string(),
        ]);
        $this->createIndex('{{%idx-shops_delivery-shop_id}}', '{{%shops_delivery}}', 'shop_id', true);
        $this->addForeignKey('{{%fk-shops_delivery-shop_id}}',
            '{{%shops_delivery}}',
            'shop_id',
            '{{%shops}}',
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
        $this->dropTable('{{%shops_delivery}}');
    }
}
