<?php

use yii\db\Migration;

/**
 * Class m200723_182936_create_stays_photo_index
 */
class m200723_182936_create_photo_indexes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('{{%idx-booking_stays-main_photo_id}}', '{{%booking_stays}}', 'main_photo_id');
        $this->addForeignKey('{{%fk-booking_stays-main_photo_id}}', '{{%booking_stays}}', 'main_photo_id', '{{%booking_stays_photos}}', 'id', 'SET NULL', 'RESTRICT');
        $this->createIndex('{{%idx-booking_rooms-main_photo_id}}', '{{%booking_rooms}}', 'main_photo_id');
        $this->addForeignKey('{{%fk-booking_rooms-main_photo_id}}', '{{%booking_rooms}}', 'main_photo_id',
            '{{%booking_rooms_photos}}', 'id', 'SET NULL', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200723_182936_create_stays_photo_index cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200723_182936_create_stays_photo_index cannot be reverted.\n";

        return false;
    }
    */
}
