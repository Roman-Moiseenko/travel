<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_stays_comfort_room_assign}}`.
 */
class m210228_213659_create_booking_stays_comfort_room_assign_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_stays_comfort_room_assign}}', [
            'stay_id' => $this->integer(),
            'comfort_id' => $this->integer(),
            'file' => $this->string(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-booking_stays_comfort_room_assign}}', '{{%booking_stays_comfort_room_assign}}', ['stay_id', 'comfort_id']);

        $this->createIndex('{{%idx-booking_stays_comfort_room_assign-stay_id}}', '{{%booking_stays_comfort_room_assign}}', 'stay_id');
        $this->createIndex('{{%idx-booking_stays_comfort_room_assign-comfort_id}}', '{{%booking_stays_comfort_room_assign}}', 'comfort_id');

        $this->addForeignKey('{{%fk-booking_stays_comfort_room_assign-stay_id}}', '{{%booking_stays_comfort_room_assign}}', 'stay_id', '{{%booking_stays}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-booking_stays_comfort_room_assign-comfort_id}}', '{{%booking_stays_comfort_room_assign}}', 'comfort_id', '{{%booking_stays_comfort_room}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_stays_comfort_room_assign}}');
    }
}
