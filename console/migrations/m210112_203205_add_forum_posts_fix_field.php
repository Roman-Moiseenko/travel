<?php

use yii\db\Migration;

/**
 * Class m210112_203205_add_forum_posts_fix_field
 */
class m210112_203205_add_forum_posts_fix_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%forum_posts}}', 'fix', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%forum_posts}}', 'fix');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210112_203205_add_forum_posts_fix_field cannot be reverted.\n";

        return false;
    }
    */
}
