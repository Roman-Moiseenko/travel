<?php

use yii\db\Migration;

/**
 * Class m210220_182655_edit_stays_id_fields2
 */
class m210220_182655_edit_stays_id_fields2 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('{{%fk-booking_stays_assign_comfort-stays_id}}', '{{%booking_stays_comfort_assign}}');
        $this->dropIndex('{{%idx-booking_stays_assign_comfort-stays_id}}', '{{%booking_stays_comfort_assign}}');
        $this->renameColumn('{{%booking_stays_comfort_assign}}', 'stays_id', 'stay_id' );
        $this->createIndex('{{%idx-booking_stays_comfort_assign-stay_id}}', '{{%booking_stays_comfort_assign}}', 'stay_id');
        $this->addForeignKey('{{%fk-booking_stays_comfort_assign-stay_id}}', '{{%booking_stays_comfort_assign}}', 'stay_id', '{{%booking_stays}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210220_182655_edit_stays_id_fields2 cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210220_182655_edit_stays_id_fields2 cannot be reverted.\n";

        return false;
    }
    */
}
