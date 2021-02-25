<?php

use yii\db\Migration;

/**
 * Class m210220_180455_edit_booking_stays_rules_fields
 */
class m210220_180455_edit_booking_stays_rules_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%booking_stays_rules}}', 'stay_id', $this->integer()->unique());
        $this->dropForeignKey('{{%fk-booking_stays_rules-stay_id}}', '{{%booking_stays_rules}}');
        $this->dropIndex('{{%idx-booking_stays_rules-stay_id}}', '{{%booking_stays_rules}}');
        $this->createIndex('{{%idx-booking_stays_rules-stay_id}}', '{{%booking_stays_rules}}', 'stay_id');
        $this->addForeignKey('{{%fk-booking_stays_rules-stay_id}}', '{{%booking_stays_rules}}', 'stay_id', '{{%booking_stays}}', 'id', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210220_180455_edit_booking_stays_rules_fields cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210220_180455_edit_booking_stays_rules_fields cannot be reverted.\n";

        return false;
    }
    */
}
