<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_funs_calendar_booking}}`.
 */
class m201207_143507_create_booking_funs_calendar_booking_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_funs_calendar_booking}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'fun_id' => $this->integer(),
            'calendar_id' => $this->integer()->notNull(),
            'status' => $this->integer(),
            'comment' => $this->string(),
            'count_adult' => $this->integer(),
            'count_child' => $this->integer(),
            'count_preference' => $this->integer(),
            'created_at' => $this->integer(),

            'payment_provider' => $this->float(),
            'pay_merchant' => $this->float(),
            'payment_id' => $this->string(),
            'confirmation' => $this->string(),

            'pincode' => $this->integer(),
            'unload' => $this->boolean(),

            'discount_id' => $this->integer(),
            'bonus' => $this->integer(),

            'give_out' => $this->boolean()->defaultValue(false),
            'give_at' => $this->integer(),
            'give_user_id' => $this->integer(),

        ], $tableOptions);

        $this->createIndex('{{%idx-booking_funs_calendar_booking-user_id}}', '{{%booking_funs_calendar_booking}}', 'user_id');
        $this->addForeignKey('{{%fk-booking_funs_calendar_booking-user_id}}', '{{%booking_funs_calendar_booking}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'RESTRICT');
        $this->createIndex('{{%idx-booking_funs_calendar_booking-fun_id}}', '{{%booking_funs_calendar_booking}}', 'fun_id');
        $this->addForeignKey('{{%fk-booking_funs_calendar_booking-fun_id}}', '{{%booking_funs_calendar_booking}}', 'fun_id', '{{%booking_funs}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_funs_calendar_booking}}');
    }
}
