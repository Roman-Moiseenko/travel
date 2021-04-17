<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shops_info_address}}`.
 */
class m210417_003715_create_shops_info_address_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%shops_info_address}}', [
//            'id' => $this->primaryKey(),
            'shop_id' => $this->integer()->notNull(),
            'phone' => $this->string(),
            'city' => $this->string(),
            'address' => $this->string()->notNull()->defaultValue(''),
            'latitude' => $this->string(),
            'longitude' => $this->string(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-shops_info_address}}', '{{%shops_info_address}}', ['shop_id', 'address']);
        $this->createIndex('{{%idx-shops_info_address-shop_id}}', '{{%shops_info_address}}', 'shop_id');
        $this->addForeignKey(
            '{{%fk-shops_info_address-shop_id}}',
            '{{%shops_info_address}}',
            'shop_id',
            '{{%shops}}',
            'id',
            'CASCADE',
            'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shops_info_address}}');
    }
}
