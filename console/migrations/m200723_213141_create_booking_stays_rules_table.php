<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_stays_rules}}`.
 */
class m200723_213141_create_booking_stays_rules_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_stays_rules}}', [
            'id' => $this->primaryKey(),
            'stays_id' => $this->integer()->notNull(),
            'beds_on' => $this->boolean(),
            'beds_count' => $this->integer(),
            'beds_upto2_on' => $this->boolean(),
            'beds_upto2_cost' => $this->integer(),
            'beds_child_on' => $this->boolean(),
            'beds_child_agelimit' => $this->integer(),
            'beds_child_cost' => $this->integer(),
            'beds_adult_on' => $this->boolean(),
            'beds_adult_cost' => $this->integer(),

            'children_on' => $this->boolean(),
            'children_agelimitfree' => $this->integer(),

            'parking_on' => $this->boolean(),
            'parking_free' => $this->boolean(),
            'parking_private' => $this->boolean(),
            'parking_inside' => $this->boolean(),
            'parking_reserve' => $this->boolean(),
            'parking_cost' => $this->integer(),

            'checkin_fulltime' => $this->boolean(),
            'checkin_checkin_from' => $this->integer(),
            'checkin_checkint_to' => $this->integer(),
            'checkin_checkout_from' => $this->integer(),
            'checkin_checkout_to' => $this->integer(),
        ]);

        $this->createIndex('{{%idx-booking_stays_rules-stays_id}}', '{{%booking_stays_rules}}', 'stays_id');
        $this->addForeignKey('{{%fk-booking_stays_rules-stays_id}}', '{{%booking_stays_rules}}', 'rooms_id', '{{%booking_stays}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_stays_rules}}');
    }
}
