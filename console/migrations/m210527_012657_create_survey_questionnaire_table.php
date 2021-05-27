<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%survey_questionnaire}}`.
 */
class m210527_012657_create_survey_questionnaire_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%survey_questionnaire}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
            'user_cookie' => $this->string()->notNull(),
            'survey_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex('{{%idx-survey_questionnaire-survey_id}}', '{{%survey_questionnaire}}', 'survey_id');
        $this->addForeignKey(
            '{{%fk-survey_questionnaire-survey_id}}',
            '{{%survey_questionnaire}}',
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
        $this->dropTable('{{%survey_questionnaire}}');
    }
}
