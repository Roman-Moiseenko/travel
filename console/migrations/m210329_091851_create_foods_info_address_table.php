<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%foods_info_address}}`.
 */
class m210329_091851_create_foods_info_address_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%foods_info_address}}', [
            'id' => $this->primaryKey(),
            'food_id' => $this->integer()->notNull(),
            'phone' => $this->string(),
            'city' => $this->string(),
            'address' => $this->string(),
            'latitude' => $this->string(),
            'longitude' => $this->string(),
        ], $tableOptions);

        $this->createIndex('{{%idx-foods_info_address-food_id}}', '{{%foods_info_address}}', 'food_id');
        $this->addForeignKey(
            '{{%fk-foods_info_address-food_id}}',
            '{{%foods_info_address}}',
            'food_id',
            '{{%foods}}',
            'id',
            'CASCADE',
            'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%foods_info_address}}');
    }
}
