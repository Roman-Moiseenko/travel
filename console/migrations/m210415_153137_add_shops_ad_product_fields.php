<?php

use yii\db\Migration;

/**
 * Class m210415_153137_add_shops_ad_product_fields
 */
class m210415_153137_add_shops_ad_product_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%shops_ad_product}}', 'views', $this->integer()->defaultValue(0));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%shops_ad_product}}', 'views');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210415_153137_add_shops_ad_product_fields cannot be reverted.\n";

        return false;
    }
    */
}
