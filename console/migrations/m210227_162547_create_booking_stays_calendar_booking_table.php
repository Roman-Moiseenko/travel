<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_stays_calendar_booking}}`.
 */
class m210227_162547_create_booking_stays_calendar_booking_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_stays_calendar_booking}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'stay_id' => $this->integer()->notNull(),
            'status' => $this->integer(),

            'created_at' => $this->integer(),
            'begin_at' => $this->integer(),
            'end_at' => $this->integer(),
            'pincode' => $this->integer(),
            'unload' => $this->boolean(),
            'guest_add' => $this->integer(),
            'comment' => $this->string(),
            'discount_id' => $this->integer(),
            'bonus' => $this->integer(),

            'confirmation' => $this->string(),
            'payment_provider' => $this->float(),
            'pay_merchant' => $this->float(),
            'payment_id' => $this->string(),
            'payment_at' => $this->integer(),
            'payment_merchant' => $this->float(),
            'payment_deduction' => $this->float(),
        ], $tableOptions);

        $this->createIndex('{{%idx-booking_stays_calendar_booking-user_id}}', '{{%booking_stays_calendar_booking}}', 'user_id');
        $this->addForeignKey('{{%fk-booking_stays_calendar_booking-user_id}}', '{{%booking_stays_calendar_booking}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'RESTRICT');
        $this->createIndex('{{%idx-booking_stays_calendar_booking-stay_id}}', '{{%booking_stays_calendar_booking}}', 'stay_id');
        $this->addForeignKey('{{%fk-booking_stays_calendar_booking-stay_id}}', '{{%booking_stays_calendar_booking}}', 'stay_id', '{{%booking_stays}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_stays_calendar_booking}}');
    }
}
