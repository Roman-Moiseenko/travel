<?php

use yii\db\Migration;

/**
 * Class m201124_150108_add_admin_help_icon_field
 */
class m201124_150108_add_admin_help_icon_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%admin_help}}', 'icon', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%admin_help}}', 'icon');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201124_150108_add_admin_help_icon_field cannot be reverted.\n";

        return false;
    }
    */
}
