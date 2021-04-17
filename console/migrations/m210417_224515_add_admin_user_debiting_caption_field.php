<?php

use yii\db\Migration;

/**
 * Class m210417_224515_add_admin_user_debiting_caption_field
 */
class m210417_224515_add_admin_user_debiting_caption_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%admin_user_debiting}}', 'caption', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%admin_user_debiting}}', 'caption');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210417_224515_add_admin_user_debiting_caption_field cannot be reverted.\n";

        return false;
    }
    */
}
