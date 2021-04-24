<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shops_order}}`.
 */
class m210422_113130_create_shops_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%shops_order}}', [
            'id' => $this->primaryKey(),
            'shop_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'number' => $this->string()->notNull(),
            'comment' => $this->text(),
            'document' => $this->string(),
            'current_status' => $this->integer()->notNull(),

            'unload' => $this->boolean()->defaultValue(false),
            'payment_id' => $this->string(),
            'payment_provider' => $this->float(),
            'payment_merchant' => $this->float(),
            'payment_deduction' => $this->float(),
            'payment_date' => $this->integer(),
            'payment_full_cost' => $this->integer(),
            'payment_prepay' => $this->integer(),
            'payment_percent' => $this->integer(),
            'payment_confirmation' => $this->string(),

            'delivery_method' => $this->integer(),
            'delivery_address_index' => $this->string(),
            'delivery_address_city' => $this->string(),
            'delivery_address_street' => $this->string(),
            'delivery_on_hands' => $this->boolean()->defaultValue(false),
            'delivery_fullname' => $this->string(),
            'delivery_phone' => $this->string(),
            'delivery_company' => $this->integer(),

        ], $tableOptions);

        $this->createIndex('{{%idx-shops_order-shop_id}}', '{{%shops_order}}', 'shop_id');
        $this->createIndex('{{%idx-shops_order-user_id}}', '{{%shops_order}}', 'user_id');

        $this->addForeignKey(
            '{{%fk-shops_order-shop_id}}',
            '{{%shops_order}}',
            'shop_id',
            '{{%shops}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
        $this->addForeignKey(
            '{{%fk-shops_order-user_id}}',
            '{{%shops_order}}',
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
        $this->dropTable('{{%shops_order}}');
    }
}
