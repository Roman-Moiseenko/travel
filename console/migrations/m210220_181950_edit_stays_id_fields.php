<?php

use yii\db\Migration;

/**
 * Class m210220_181950_edit_stays_id_fields
 */
class m210220_181950_edit_stays_id_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->dropForeignKey('{{%fk-booking_stays_photos-stays_id}}', '{{%booking_stays_photos}}');
        $this->dropIndex('{{%idx-booking_stays_photos-stays_id}}', '{{%booking_stays_photos}}');
        $this->renameColumn('{{%booking_stays_photos}}', 'stays_id', 'stay_id');
        $this->createIndex('{{%idx-booking_stays_photos-stay_id}}', '{{%booking_stays_photos}}', 'stay_id');
        $this->addForeignKey('{{%fk-booking_stays_photos-stay_id}}', '{{%booking_stays_photos}}', 'stay_id', '{{%booking_stays}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210220_181950_edit_stays_id_fields cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210220_181950_edit_stays_id_fields cannot be reverted.\n";

        return false;
    }
    */
}
