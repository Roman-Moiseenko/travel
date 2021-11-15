<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%touristic_stay_category}}`.
 */
class m211111_204934_create_touristic_stay_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%touristic_stay_category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'title' => $this->string(),
            'description' => $this->text(),
            'slug' => $this->string(),
            'sort' => $this->integer(),
            'photo' => $this->string(),
            'meta_json' => 'JSON NOT NULL',
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%touristic_stay_category}}');
    }
}
