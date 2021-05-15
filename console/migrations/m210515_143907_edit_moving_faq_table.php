<?php

use yii\db\Migration;

/**
 * Class m210515_143907_edit_moving_faq_table
 */
class m210515_143907_edit_moving_faq_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%moving_faq}}', 'answer', $this->text());
        $this->addColumn('{{%moving_faq}}', 'question', $this->text());
        $this->dropColumn('{{%moving_faq}}', 'message');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%moving_faq}}', 'answer');
        $this->dropColumn('{{%moving_faq}}', 'question');
        $this->addColumn('{{%moving_faq}}', 'message', $this->text());
    }

}
