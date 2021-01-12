<?php

use yii\db\Migration;

/**
 * Class m210112_224632_update_admin_user_forum_read_last_id_field
 */
class m210112_224632_update_admin_user_forum_read_last_id_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%admin_user_forum_read}}', 'last_id', 'last_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210112_224632_update_admin_user_forum_read_last_id_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210112_224632_update_admin_user_forum_read_last_id_field cannot be reverted.\n";

        return false;
    }
    */
}
