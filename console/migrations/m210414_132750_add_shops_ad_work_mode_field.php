<?php

use yii\db\Migration;

/**
 * Class m210414_132750_add_shops_ad_work_mode_field
 */
class m210414_132750_add_shops_ad_work_mode_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%shops_ad}}', 'work_mode_json', 'JSON');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%shops_ad}}', 'work_mode_json');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210414_132750_add_shops_ad_work_mode_field cannot be reverted.\n";

        return false;
    }
    */
}
