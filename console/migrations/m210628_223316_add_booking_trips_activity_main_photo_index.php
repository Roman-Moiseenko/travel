<?php

use yii\db\Migration;

/**
 * Class m210628_223316_add_booking_trips_activity_main_photo_index
 */
class m210628_223316_add_booking_trips_activity_main_photo_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('{{%idx-booking_trips_activity-main_photo_id}}', '{{%booking_trips_activity}}', 'main_photo_id');
        $this->addForeignKey(
            '{{%fk-booking_trips_activity-main_photo_id}}',
            '{{%booking_trips_activity}}',
            'main_photo_id',
            '{{%booking_trips_activity_photos}}',
            'id',
            'CASCADE',
            'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210628_223316_add_booking_trips_activity_main_photo_index cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210628_223316_add_booking_trips_activity_main_photo_index cannot be reverted.\n";

        return false;
    }
    */
}
