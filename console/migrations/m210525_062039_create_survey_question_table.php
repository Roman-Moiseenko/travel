<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%survey_question}}`.
 */
class m210525_062039_create_survey_question_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%survey_question}}', [
            'id' => $this->primaryKey(),
            'survey_id' => $this->integer()->notNull(),
            'question' => $this->string(),
            'sort' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('{{%idx-survey_question-survey_id}}', '{{%survey_question}}', 'survey_id');
        $this->addForeignKey(
            '{{%fk-survey_question-survey_id}}',
            '{{%survey_question}}',
            'survey_id',
            '{{%survey}}',
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
        $this->dropTable('{{%survey_question}}');
    }
}
