<?php

use yii\db\Migration;

/**
 * Class m210428_182406_add_shops_delivery_fields
 */
class m210428_182406_add_shops_delivery_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%shops}}', 'delivery_on_city', $this->boolean()->defaultValue(false));
        $this->addColumn('{{%shops}}', 'delivery_cost_city', $this->integer()->defaultValue(0));
        $this->addColumn('{{%shops}}', 'delivery_min_amount_city', $this->integer()->defaultValue(0));
        $this->addColumn('{{%shops}}', 'delivery_min_amount_company', $this->integer()->defaultValue(0));
        $this->addColumn('{{%shops}}', 'delivery_period', $this->integer()->defaultValue(0));
        $this->addColumn('{{%shops}}', 'delivery_on_point', $this->boolean()->defaultValue(false));
        $this->addColumn('{{%shops}}', 'delivery_address', $this->string());
        $this->addColumn('{{%shops}}', 'delivery_latitude', $this->string());
        $this->addColumn('{{%shops}}', 'delivery_longitude', $this->string());
        $this->addColumn('{{%shops}}', 'delivery_companies', 'JSON');
        $this->dropColumn('{{%shops}}', 'delivery_json');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210428_182406_add_shops_delivery_fields cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210428_182406_add_shops_delivery_fields cannot be reverted.\n";

        return false;
    }
    */
}
