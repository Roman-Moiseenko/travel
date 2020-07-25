<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_tours_calendar_cost}}`.
 */
class m200724_223552_create_booking_tours_calendar_cost_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_tours_calendar_cost}}', [
            'id' => $this->primaryKey(),
            'tours_id' => $this->integer(),
            'tour_at' => $this->integer(),
            'cost_adult' => $this->integer(),
            'cost_child' => $this->integer(),
            'cost_preference' => $this->integer(),
        ], $tableOptions);
        $this->createIndex('{{%idx-booking_tours_calendar_cost-tours_id}}', '{{%booking_tours_calendar_cost}}','tours_id');
        $this->addForeignKey('{{%fk-booking_tours_calendar_cost-tours_id}}', '{{%booking_tours_calendar_cost}}', 'tours_id', '{{%booking_tours}}', 'id', 'SET NULL', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_tours_calendar_cost}}');
    }
}
