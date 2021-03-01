<?php

use yii\db\Migration;

/**
 * Class m210301_134846_edit_booking_stays_comfort_assign_fields
 */
class m210301_134846_edit_booking_stays_comfort_assign_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_stays_comfort_assign}}', 'file', $this->string());
        $this->dropColumn('{{%booking_stays_comfort_assign}}', 'photo_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_stays_comfort_assign}}', 'file');
        $this->addColumn('{{%booking_stays_comfort_assign}}', 'photo_id', $this->integer());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210301_134846_edit_booking_stays_comfort_assign_fields cannot be reverted.\n";

        return false;
    }
    */
}
