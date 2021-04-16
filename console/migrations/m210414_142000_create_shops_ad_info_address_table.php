<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shops_ad_info_address}}`.
 */
class m210414_142000_create_shops_ad_info_address_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%shops_ad_info_address}}', [
//            'id' => $this->primaryKey(),
            'shop_id' => $this->integer()->notNull(),
            'phone' => $this->string(),
            'city' => $this->string(),
            'address' => $this->string(),
            'latitude' => $this->string(),
            'longitude' => $this->string(),
        ], $tableOptions);

        $this->createIndex('{{%idx-shops_ad_info_address-shop_id}}', '{{%shops_ad_info_address}}', 'shop_id');
        $this->addForeignKey(
            '{{%fk-shops_ad_info_address-shop_id}}',
            '{{%shops_ad_info_address}}',
            'shop_id',
            '{{%shops_ad}}',
            'id',
            'CASCADE',
            'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shops_ad_info_address}}');
    }
}
