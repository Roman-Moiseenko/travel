<?php

use yii\db\Migration;

/**
 * Class m210112_223319_update_forum_messages_text_field
 */
class m210112_223319_update_forum_messages_text_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%forum_messages}}', 'text', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210112_223319_update_forum_messages_text_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210112_223319_update_forum_messages_text_field cannot be reverted.\n";

        return false;
    }
    */
}
