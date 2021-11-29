<?php

use booking\helpers\StatusHelper;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%realtor_pages}}`.
 */
class m211129_100438_create_realtor_pages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%realtor_pages}}', [
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

        $this->createIndex('{{%idx-realtor_pages-slug}}', '{{%realtor_pages}}', 'slug');

        $this->insert('{{%realtor_pages}}', [
            'id' => 1,
            'title' => '',
            'slug' => 'root',
            'content' => null,
            'meta_json' => '{}',
            'lft' => 1,
            'rgt' => 2,
            'depth' => 0,
            'status' => StatusHelper::STATUS_ACTIVE,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%realtor_pages}}');
    }
}
