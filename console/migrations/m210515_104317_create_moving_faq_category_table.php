<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%moving_faq_category}}`.
 */
class m210515_104317_create_moving_faq_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%moving_faq_category}}', [
            'id' => $this->primaryKey(),
            'sort' => $this->integer(),
            'caption' => $this->string(),
            'description' => $this->text(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%moving_faq_category}}');
    }
}
