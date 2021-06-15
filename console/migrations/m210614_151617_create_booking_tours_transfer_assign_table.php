<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_tours_transfer_assign}}`.
 */
class m210614_151617_create_booking_tours_transfer_assign_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_tours_transfer_assign}}', [
            'tour_id' => $this->integer()->notNull(),
            'transfer_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('{{%pk-booking_tours_transfer_assign}}', '{{%booking_tours_transfer_assign}}', ['tour_id', 'transfer_id']);
        $this->createIndex('{{%idx-booking_tours_transfer_assign-tour_id}}', '{{%booking_tours_transfer_assign}}', 'tour_id');
        $this->addForeignKey('{{%fk-booking_tours_transfer_assign-tour_id}}',
            '{{%booking_tours_transfer_assign}}',
            'tour_id',
            '{{%booking_tours}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
        $this->createIndex('{{%idx-booking_tours_transfer_assign-transfer_id}}', '{{%booking_tours_transfer_assign}}', 'transfer_id');
        $this->addForeignKey('{{%fk-booking_tours_transfer_assign-transfer_id}}',
            '{{%booking_tours_transfer_assign}}',
            'transfer_id',
            '{{%users_tour_transfer}}',
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
        $this->dropTable('{{%booking_tours_transfer_assign}}');
    }
}
