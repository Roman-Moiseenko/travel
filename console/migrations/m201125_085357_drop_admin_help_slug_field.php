<?php

use yii\db\Migration;

/**
 * Class m201125_085357_drop_admin_help_slug_field
 */
class m201125_085357_drop_admin_help_slug_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%admin_help}}', 'slug');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%admin_help}}', 'slug', $this->string()->unique());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201125_085357_drop_admin_help_slug_field cannot be reverted.\n";

        return false;
    }
    */
}
