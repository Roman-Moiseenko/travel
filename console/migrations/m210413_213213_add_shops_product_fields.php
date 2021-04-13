<?php

use yii\db\Migration;

/**
 * Class m210413_213213_add_shops_product_fields
 */
class m210413_213213_add_shops_product_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%shops_product}}', 'views', $this->integer()->defaultValue(0));
        $this->addColumn('{{%shops_product}}', 'buys', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%shops_product}}', 'views');
        $this->dropColumn('{{%shops_product}}', 'buys');
    }

}
