<?php

use yii\db\Migration;

/**
 * Class m201025_222313_drop_payment_pay_legal_field
 */
class m201025_222313_drop_payment_pay_legal_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('payment', 'pay_legal');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('payment', 'pay_legal', $this->float());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201025_222313_drop_payment_pay_legal_field cannot be reverted.\n";

        return false;
    }
    */
}
