<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_tours_capacity_assign}}`.
 */
class m210613_203837_create_booking_tours_capacity_assign_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_tours_capacity_assign}}', [
            'tour_id' => $this->integer()->notNull(),
            'capacity_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('{{%pk-booking_tours_capacity_assign}}', '{{%booking_tours_capacity_assign}}', ['tour_id', 'capacity_id']);
        $this->createIndex('{{%idx-booking_tours_capacity_assign-tour_id}}', '{{%booking_tours_capacity_assign}}', 'tour_id');
        $this->addForeignKey('{{%fk-booking_tours_capacity_assign-tour_id}}',
            '{{%booking_tours_capacity_assign}}',
            'tour_id',
            '{{%booking_tours}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
        $this->createIndex('{{%idx-booking_tours_capacity_assign-capacity_id}}', '{{%booking_tours_capacity_assign}}', 'capacity_id');
        $this->addForeignKey('{{%fk-booking_tours_capacity_assign-capacity_id}}',
            '{{%booking_tours_capacity_assign}}',
            'capacity_id',
            '{{%users_tour_capacity}}',
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
        $this->dropTable('{{%booking_tours_capacity_assign}}');
    }
}
