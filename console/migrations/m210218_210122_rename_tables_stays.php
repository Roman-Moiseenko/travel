<?php

use yii\db\Migration;

/**
 * Class m210218_210122_rename_tables_stays
 */
class m210218_210122_rename_tables_stays extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameTable('{{%booking_stay_rooms_assign}}', '{{%booking_stays_rooms_assign}}');
        $this->renameTable('{{%booking_stay_nearby_category}}', '{{%booking_stays_nearby_category}}');
        //$this->renameTable('{{%booking_stay_nearby}}', '{{%booking_stays_nearby}}');
        $this->renameTable('{{%booking_stay_beds_assign}}', '{{%booking_stays_beds_assign}}');
        $this->renameTable('{{%booking_stay_bed_type}}', '{{%booking_stays_bed_type}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210218_210122_rename_tables_stays cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210218_210122_rename_tables_stays cannot be reverted.\n";

        return false;
    }
    */
}
