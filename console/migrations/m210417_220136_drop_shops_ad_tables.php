<?php

use yii\db\Migration;

/**
 * Class m210417_220136_drop_shops_ad_tables
 */
class m210417_220136_drop_shops_ad_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('{{%shops_ad_reviews}}');
        $this->dropTable('{{%shops_ad_product_reviews}}');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210417_220136_drop_shops_ad_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210417_220136_drop_shops_ad_tables cannot be reverted.\n";

        return false;
    }
    */
}
