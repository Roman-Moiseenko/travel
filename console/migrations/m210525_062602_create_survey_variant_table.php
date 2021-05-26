<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%survey_variant}}`.
 */
class m210525_062602_create_survey_variant_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%survey_variant}}', [
            'id' => $this->primaryKey(),
            'question_id' => $this->integer()->notNull(),
            'sort' => $this->integer(),
            'text' => $this->text(),
        ], $tableOptions);

        $this->createIndex('{{%idx-survey_variant-question_id}}', '{{%survey_variant}}', 'question_id');
        $this->addForeignKey(
            '{{%fk-survey_variant-question_id}}',
            '{{%survey_variant}}',
            'question_id',
            '{{%survey_question}}',
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
        $this->dropTable('{{%survey_variant}}');
    }
}
