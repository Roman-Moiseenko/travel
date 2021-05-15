<?php

use yii\db\Migration;

/**
 * Class m210515_145651_edit_moving_faq_table
 */
class m210515_145651_edit_moving_faq_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('{{%fk-moving_faq-user_id}}', '{{%moving_faq}}');
        $this->dropIndex('{{%idx-moving_faq-user_id}}', '{{%moving_faq}}');
        $this->dropColumn('{{%moving_faq}}', 'user_id');

        $this->addColumn('{{%moving_faq}}', 'username', $this->string());
        $this->addColumn('{{%moving_faq}}', 'email', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210515_145651_edit_moving_faq_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210515_145651_edit_moving_faq_table cannot be reverted.\n";

        return false;
    }
    */
}
