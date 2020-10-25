<?php

use yii\db\Migration;

/**
 * Class m201025_140623_add_booking_tours_pay_bank_field
 */
class m201025_140623_add_booking_tours_pay_bank_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_tours}}', 'pay_bank', $this->boolean()->defaultValue(true));
        $this->update('{{%booking_tours}}', ['pay_bank' => true]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_tours}}', 'pay_bank');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201025_140623_add_booking_tours_pay_bank_field cannot be reverted.\n";

        return false;
    }
    */
}
