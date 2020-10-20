<?php

use yii\db\Migration;

/**
 * Class m201020_153514_add_admin_user_legals_en_fields
 */
class m201020_153514_add_admin_user_legals_en_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%admin_user_legals}}', 'caption_en', $this->string());
        $this->addColumn('{{%admin_user_legals}}', 'description_en', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%admin_user_legals}}', 'caption_en');
        $this->dropColumn('{{%admin_user_legals}}', 'description_en');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201020_153514_add_admin_user_legals_en_fields cannot be reverted.\n";

        return false;
    }
    */
}
