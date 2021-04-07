<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shops_product_category}}`.
 */
class m210407_150238_create_shops_product_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%shops_product_category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'slug' => $this->string()->unique(),
            'title' => $this->string(),
            'description' => $this->text(),
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'depth' => $this->integer()->notNull(),
            'meta_json' => 'JSON NOT NULL',
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shops_product_category}}');
    }
}
