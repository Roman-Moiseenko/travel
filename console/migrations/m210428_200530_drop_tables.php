<?php

use yii\db\Migration;

/**
 * Class m210428_200530_drop_tables
 */
class m210428_200530_drop_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('{{%fk-shops_delivery_company_assign-delivery_company_id}}','{{%shops_delivery_company_assign}}');
        $this->dropForeignKey('fk-shops_delivery_company_assign-delivery_id','{{%shops_delivery_company_assign}}');
        $this->dropTable('{{%shops_delivery_company_assign}}');
        $this->dropForeignKey('{{%fk-shops_delivery-shop_id}}','{{%shops_delivery}}');
        $this->dropTable('{{%shops_delivery}}');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210428_200530_drop_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210428_200530_drop_tables cannot be reverted.\n";

        return false;
    }
    */
}
