<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%survey_questionnaire_answer}}`.
 */
class m210527_012719_create_survey_questionnaire_answer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%survey_questionnaire_answer}}', [
            'id' => $this->primaryKey(),
            'questionnaire_id' => $this->integer()->notNull(),
            'question_id' => $this->integer()->notNull(),
            'variant_id' => $this->integer()->notNull(),
        ]);
        $this->createIndex('{{%idx-survey_questionnaire_answer-questionnaire_id}}', '{{%survey_questionnaire_answer}}', 'questionnaire_id');
        $this->addForeignKey(
            '{{%idx-survey_questionnaire_answer-questionnaire_id}}',
            '{{%survey_questionnaire_answer}}',
            'questionnaire_id',
            '{{%survey_questionnaire}}',
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
        $this->dropTable('{{%survey_questionnaire_answer}}');
    }
}
