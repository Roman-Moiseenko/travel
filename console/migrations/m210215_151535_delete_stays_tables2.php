<?php

use yii\db\Migration;

/**
 * Class m210215_151535_delete_stays_tables2
 */
class m210215_151535_delete_stays_tables2 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('{{%booking_stays_rules}}');

        $this->renameColumn('{{%booking_stays_comfort}}', 'editpay', 'paid');
        $this->addColumn('{{%booking_stays_comfort}}', 'image', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210215_151535_delete_stays_tables2 cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210215_151535_delete_stays_tables2 cannot be reverted.\n";

        return false;
    }
    */
}
