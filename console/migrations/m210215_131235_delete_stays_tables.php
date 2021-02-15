<?php

use yii\db\Migration;

/**
 * Class m210215_131235_delete_stays_tables
 */
class m210215_131235_delete_stays_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('{{%fk-booking_rooms-main_photo_id}}', '{{%booking_rooms}}');
        $this->dropTable('{{%booking_rooms_photos}}');
        $this->dropTable('{{%booking_rooms}}');
        $this->dropTable('{{%booking_rooms_type}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210215_131235_delete_stays_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210215_131235_delete_stays_tables cannot be reverted.\n";

        return false;
    }
    */
}
