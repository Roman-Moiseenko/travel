<?php

use yii\db\Migration;

/**
 * Class m210415_163937_add_shops_ad_balances_fields
 */
class m210415_163937_add_shops_ad_balances_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%shops_ad}}', 'current_balance', $this->decimal(10, 2));
        $this->addColumn('{{%shops_ad}}', 'free_products', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%shops_ad}}', 'current_balance');
        $this->dropColumn('{{%shops_ad}}', 'free_products');
    }

}
