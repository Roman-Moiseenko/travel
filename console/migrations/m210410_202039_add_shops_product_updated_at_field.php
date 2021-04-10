<?php

use yii\db\Migration;

/**
 * Class m210410_202039_add_shops_product_updated_at_field
 */
class m210410_202039_add_shops_product_updated_at_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%shops_product}}', 'updated_at', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%shops_product}}', 'updated_at');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210410_202039_add_shops_product_updated_at_field cannot be reverted.\n";

        return false;
    }
    */
}
