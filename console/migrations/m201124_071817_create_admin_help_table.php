<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%admin_pages}}`.
 */
class m201124_071817_create_admin_help_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%admin_help}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'content' => 'MEDIUMTEXT',
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'depth' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-admin_help-slug}}', '{{%admin_help}}', 'slug', true);

        $this->insert('{{%admin_help}}', [
            'id' => 1,
            'title' => '',
            'slug' => 'root',
            'content' => null,
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
        $this->dropTable('{{%admin_help}}');
    }
}
