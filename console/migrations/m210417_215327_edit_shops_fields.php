<?php

use yii\db\Migration;

/**
 * Class m210417_215327_edit_shops_fields
 */
class m210417_215327_edit_shops_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%shops}}', 'active_products', $this->integer()->defaultValue(0));
        $this->alterColumn('{{%shops}}', 'free_products', $this->integer()->defaultValue(0));
        $this->update('{{%shops}}', ['active_products' => 0]);
        $this->update('{{%shops}}', ['free_products' => 0]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210417_215327_edit_shops_fields cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210417_215327_edit_shops_fields cannot be reverted.\n";

        return false;
    }
    */
}
