<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_funs_calendar_cost}}`.
 */
class m201201_215306_create_booking_funs_calendar_cost_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_funs_calendar_cost}}', [
            'id' => $this->primaryKey(),
            'fun_id' => $this->integer(),
            'fun_at' => $this->integer(),
            'time_at' => $this->string(5),
            'cost_adult' => $this->integer(),
            'cost_child' => $this->integer(),
            'cost_preference' => $this->integer(),
            'tickets' => $this->integer(),
            'status' => $this->integer(),
        ], $tableOptions);
        $this->createIndex('{{%idx-booking_funs_calendar_cost-fun_id}}', '{{%booking_funs_calendar_cost}}','fun_id');
        $this->createIndex('{{%idx-booking_funs_calendar_cost-unique}}',
            '{{%booking_funs_calendar_cost}}',
            ['fun_id', 'fun_at', 'time_at'], true);
        $this->addForeignKey('{{%fk-booking_funs_calendar_cost-fun_id}}', '{{%booking_funs_calendar_cost}}', 'fun_id', '{{%booking_funs}}', 'id', 'SET NULL', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_funs_calendar_cost}}');
    }
}
