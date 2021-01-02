<?php

use yii\db\Migration;

/**
 * Class m210102_203510_drop_pay_bank_fields
 */
class m210102_203510_drop_pay_bank_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%booking_tours}}', 'pay_bank');
        $this->dropColumn('{{%booking_cars}}', 'pay_bank');
        $this->dropColumn('{{%booking_funs}}', 'pay_bank');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%booking_tours}}', 'pay_bank', $this->boolean()->defaultValue(true));
        $this->addColumn('{{%booking_cars}}', 'pay_bank', $this->boolean()->defaultValue(true));
        $this->addColumn('{{%booking_funs}}', 'pay_bank', $this->boolean()->defaultValue(true));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210102_203510_drop_pay_bank_fields cannot be reverted.\n";

        return false;
    }
    */
}
