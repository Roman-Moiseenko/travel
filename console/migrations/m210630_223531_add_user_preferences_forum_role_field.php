<?php

use booking\helpers\UserForumHelper;
use yii\db\Migration;

/**
 * Class m210630_223531_add_user_preferences_forum_role_field
 */
class m210630_223531_add_user_preferences_forum_role_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user_preferences}}', 'forum_role', $this->integer()->defaultValue(UserForumHelper::FORUM_USER));
        $this->update('{{%user_preferences}}', ['forum_role' => UserForumHelper::FORUM_USER]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210630_223531_add_user_preferences_forum_role_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210630_223531_add_user_preferences_forum_role_field cannot be reverted.\n";

        return false;
    }
    */
}
