<?php

use yii\db\Migration;

/**
 * Class m210225_201441_edit_booking_stays_cost_fields
 */
class m210225_201441_edit_booking_stays_cost_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%booking_stays}}', 'cost', 'cost_base');
        $this->addColumn('{{%booking_stays}}', 'guest_base', $this->integer());
        $this->addColumn('{{%booking_stays}}', 'cost_add', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('{{%booking_stays}}', 'cost_base', 'cost');
        $this->dropColumn('{{%booking_stays}}', 'guest_base');
        $this->dropColumn('{{%booking_stays}}', 'cost_add');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210225_201441_edit_booking_stays_cost_fields cannot be reverted.\n";

        return false;
    }
    */
}
