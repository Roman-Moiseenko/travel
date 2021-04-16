<?php

use yii\db\Migration;

/**
 * Class m210415_193133_add_shops_ad_product_update_at_field
 */
class m210415_193133_add_shops_ad_product_update_at_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%shops_ad_product}}', 'updated_at', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%shops_ad_product}}', 'updated_at');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210415_193133_add_shops_ad_product_update_at_field cannot be reverted.\n";

        return false;
    }
    */
}
