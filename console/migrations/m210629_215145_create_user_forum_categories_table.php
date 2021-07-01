<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_forum_categories}}`.
 */
class m210629_215145_create_user_forum_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%user_forum_categories}}', [
            'id' => $this->primaryKey(),
            'section_id' => $this->integer()->notNull(),
            'name' => $this->string(),
            'description' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer(),
            'count' => $this->integer()->notNull(),
            'last_id' => $this->integer(),
            'status' => $this->integer()->notNull(),
            'sort' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-user_forum_categories-section_id}}', '{{%user_forum_categories}}', 'section_id');
        $this->addForeignKey(
            '{{%idx-user_forum_categories-section_id}}',
            '{{%user_forum_categories}}',
            'section_id',
            '{{%user_forum_sections}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_forum_categories}}');
    }
}
