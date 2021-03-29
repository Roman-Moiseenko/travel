<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%foods}}`.
 */
class m210329_081349_create_foods_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%foods}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer(),
            'visible' => $this->boolean(),
            'main_photo_id' => $this->integer(),
            'description' => $this->text(),
            'meta_json' => 'JSON',
            'work_mode_json' => 'JSON',

        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%foods}}');
    }
}
