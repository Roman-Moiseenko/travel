<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_stay_beds_assign}}`.
 */
class m210217_201300_create_booking_stay_beds_assign_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {


        $this->createTable('{{%booking_stay_beds_assign}}', [
            'assignRoom_id' => $this->integer()->notNull(),
            'bed_id' => $this->integer()->notNull(),
            'count' => $this->integer()->notNull()->defaultValue(1),
        ]);
        $this->addPrimaryKey('{{%pk-booking_stay_beds_assign}}', '{{%booking_stay_beds_assign}}', ['assignRoom_id', 'bed_id']);

        $this->createIndex('{{%idx-booking_stay_beds_assign-assignRoom_id}}', '{{%booking_stay_beds_assign}}', 'assignRoom_id');
        $this->createIndex('{{%idx-booking_stay_beds_assign-bed_id}}', '{{%booking_stay_beds_assign}}', 'bed_id');
        $this->addForeignKey('{{%fk-booking_stay_beds_assign-assignRoom_id}}', '{{%booking_stay_beds_assign}}', 'assignRoom_id', '{{%booking_stay_rooms_assign}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-booking_stay_beds_assign-bed_id}}', '{{%booking_stay_beds_assign}}', 'bed_id', '{{%booking_stay_bed_type}}', 'id', 'CASCADE', 'RESTRICT');


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_stay_beds_assign}}');
    }
}
