<?php

use yii\db\Migration;

/**
 * Class m210416_113307_edit_admin_user_debiting_type_field
 */
class m210416_113307_edit_admin_user_debiting_type_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%admin_user_debiting}}', 'type', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210416_113307_edit_admin_user_debiting_type_field cannot be reverted.\n";

        return false;
    }

}
