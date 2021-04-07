<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shops_product_material}}`.
 */
class m210407_203319_create_shops_product_material_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%shops_product_material}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shops_product_material}}');
    }
}
