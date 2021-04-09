<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shops_delivery_company}}`.
 */
class m210408_143617_create_shops_delivery_company_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%shops_delivery_company}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'link' => $this->string(),
            'api_json' => 'JSON',
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shops_delivery_company}}');
    }
}
