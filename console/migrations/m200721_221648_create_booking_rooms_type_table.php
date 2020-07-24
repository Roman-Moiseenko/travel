<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_rooms_type}}`.
 */
class m200721_221648_create_booking_rooms_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_rooms_type}}', [
            'id' => $this->primaryKey(),
            'stays_id' => $this->integer(),
            'name' => $this->string(),
        ], $tableOptions);
        $this->addForeignKey('{{%fk-booking_rooms_type-stays_id}}', '{{%booking_rooms_type}}', 'stays_id',
            '{{%booking_stays_type}}', 'id', 'SET NULL', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_rooms_type}}');
    }
}
