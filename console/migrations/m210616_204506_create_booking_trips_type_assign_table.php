<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_trips_type_assign}}`.
 */
class m210616_204506_create_booking_trips_type_assign_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_trips_type_assign}}', [
            'trip_id' => $this->integer()->notNull(),
            'type_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('{{%pk-booking_trips_type_assign}}', '{{%booking_trips_type_assign}}', ['trip_id', 'type_id']);
        $this->createIndex('{{%idx-booking_trips_type_assign-trip_id}}', '{{%booking_trips_type_assign}}', 'trip_id');
        $this->addForeignKey('{{%fk-booking_trips_type_assign-trip_id}}',
            '{{%booking_trips_type_assign}}',
            'trip_id',
            '{{%booking_trips}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
        $this->createIndex('{{%idx-booking_trips_type_assign-type_id}}', '{{%booking_trips_type_assign}}', 'type_id');
        $this->addForeignKey('{{%fk-booking_trips_type_assign-type_id}}',
            '{{%booking_trips_type_assign}}',
            'type_id',
            '{{%booking_trips_type}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_trips_type_assign}}');
    }
}
