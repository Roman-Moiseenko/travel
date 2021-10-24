<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%medicine_pages}}`.
 */
class m211024_210756_create_medicine_pages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%medicine_pages}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'slug' => $this->string(),
            'content' => 'MEDIUMTEXT',
            'meta_json' => 'JSON NOT NULL',
            'lft' => $this->integer(),
            'rgt' => $this->integer(),
            'depth' => $this->integer(),
            'icon' => $this->string(),
            'name' => $this->string(),
            'photo' => $this->string(),
            'description' => $this->text(),
            'status' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('{{%idx-medicine_pages-slug}}', '{{%medicine_pages}}', 'slug');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%medicine_pages}}');
    }
}
