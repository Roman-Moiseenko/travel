<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%forum_categories}}`.
 */
class m201213_221524_create_forum_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%forum_categories}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'description' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer(),
            'count' => $this->integer()->notNull(),
            'last_id' => $this->integer(),
            'status' => $this->integer()->notNull(),
            'sort' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%forum_categories}}');
    }
}
