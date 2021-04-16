<?php

use yii\db\Migration;

/**
 * Class m210416_095149_rename_shops_ad_field
 */
class m210416_095149_rename_shops_ad_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%shops_ad}}', 'current_balance', 'active_products');
        $this->alterColumn('{{%shops_ad}}', 'active_products', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210416_095149_rename_shops_ad_field cannot be reverted.\n";

        return false;
    }

}
