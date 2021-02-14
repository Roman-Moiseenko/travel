<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_tours_stack_assign}}`.
 */
class m210214_153852_create_booking_tours_stack_assign_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_tours_stack_assign}}', [
            'stack_id' => $this->integer()->notNull(),
            'tour_id' => $this->integer()->notNull(),
        ]);
        $this->addPrimaryKey('{{%pk-booking_tours_stack_assign}}', '{{%booking_tours_stack_assign}}', ['stack_id', 'tour_id']);

        $this->createIndex('{{%idx-booking_tours_stack_assign-stack_id}}', '{{%booking_tours_stack_assign}}', 'stack_id');
        $this->createIndex('{{%idx-booking_tours_stack_assign-tour_id}}', '{{%booking_tours_stack_assign}}', 'tour_id');

        $this->addForeignKey('{{%fk-booking_tours_stack_assign-stack_id}}', '{{%booking_tours_stack_assign}}', 'stack_id', '{{%booking_tours_stack}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-booking_tours_stack_assign-tour_id}}', '{{%booking_tours_stack_assign}}', 'tour_id', '{{%booking_tours}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_tours_stack_assign}}');
    }
}
