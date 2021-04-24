<?php

use yii\db\Migration;

/**
 * Class m210422_161150_del_shops_product_request_available_field
 */
class m210422_161150_del_shops_product_request_available_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%shops_product}}', 'request_available');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210422_161150_del_shops_product_request_available_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210422_161150_del_shops_product_request_available_field cannot be reverted.\n";

        return false;
    }
    */
}
