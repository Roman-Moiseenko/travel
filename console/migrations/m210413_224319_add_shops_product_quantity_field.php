<?php

use yii\db\Migration;

/**
 * Class m210413_224319_add_shops_product_quantity_field
 */
class m210413_224319_add_shops_product_quantity_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%shops_product}}', 'quantity', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%shops_product}}', 'quantity');
    }

}
