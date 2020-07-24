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
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
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

            'agelimit_on' => $this->boolean(),
            'agelimit_ageMin' => $this->integer(),
            'agelimit_ageMax' => $this->integer(),

            'cards_on' => $this->boolean(),
            'cards_list' => $this->text()
        ], $tableOptions);

        $this->createIndex('{{%idx-booking_stays_rules-stays_id}}', '{{%booking_stays_rules}}', 'stays_id');
        $this->addForeignKey('{{%fk-booking_stays_rules-stays_id}}', '{{%booking_stays_rules}}', 'stays_id', '{{%booking_stays}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_stays_rules}}');
    }
}
