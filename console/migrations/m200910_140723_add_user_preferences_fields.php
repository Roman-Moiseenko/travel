<?php

use yii\db\Migration;

/**
 * Class m200910_140723_add_user_preferences_fields
 */
class m200910_140723_add_user_preferences_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%user_preferences}}', 'smocking', $this->integer()->defaultValue(0));
        $this->addColumn('{{%user_preferences}}','stars', $this->integer()->defaultValue(0));
        $this->addColumn('{{%user_preferences}}','disabled', $this->boolean()->defaultValue(false));
        $this->addColumn('{{%user_preferences}}','newsletter', $this->boolean()->defaultValue(false));
        $this->addColumn('{{%user_preferences}}','notice_dialog', $this->boolean()->defaultValue(true));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%user_preferences}}', 'smocking', $this->boolean());
        $this->dropColumn('{{%user_preferences}}','stars');
        $this->dropColumn('{{%user_preferences}}','disabled');
        $this->dropColumn('{{%user_preferences}}','newsletter');
        $this->dropColumn('{{%user_preferences}}','notice_dialog');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200910_140723_add_user_preferences_fields cannot be reverted.\n";

        return false;
    }
    */
}
