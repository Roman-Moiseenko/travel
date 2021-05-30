<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%office_price_list}}`.
 */
class m210530_065508_create_office_price_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%office_price_list}}', [
            'id' => $this->primaryKey(),
            'key' => $this->string()->notNull()->unique(),
            'amount' => $this->decimal(6, 2),
            'period' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%office_price_list}}');
    }
}
