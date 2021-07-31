<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%night_pages}}`.
 */
class m210730_200709_create_night_pages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%night_pages}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'description' => $this->text(),
            'content' => 'MEDIUMTEXT',
            'meta_json' => 'JSON NOT NULL',
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'depth' => $this->integer()->notNull(),
            'icon' => $this->string(),
            'photo' => $this->string(),
            'name' => $this->string(),
        ], $tableOptions);

        $this->createIndex('{{%idx-night_pages-slug}}', '{{%night_pages}}', 'slug', true);

        $this->insert('{{%night_pages}}', [
            'id' => 1,
            'title' => '',
            'slug' => 'root',
            'content' => null,
            'meta_json' => '{}',
            'lft' => 1,
            'rgt' => 2,
            'depth' => 0,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%night_pages}}');
    }
}
