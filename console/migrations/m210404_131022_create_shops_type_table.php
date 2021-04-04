<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shops_type}}`.
 */
class m210404_131022_create_shops_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%shops_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(33),
            'slug' => $this->string(33),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shops_type}}');
    }
}
