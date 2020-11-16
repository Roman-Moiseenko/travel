<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_cars_extra_assign}}`.
 */
class m201105_214216_create_booking_cars_extra_assign_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_cars_extra_assign}}', [
            'car_id' => $this->integer()->notNull(),
            'extra_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-booking_cars_extra_assign}}', '{{%booking_cars_extra_assign}}', ['car_id', 'extra_id']);

        $this->createIndex('{{%idx-booking_cars_extra_assign-car_id}}', '{{%booking_cars_extra_assign}}', 'car_id');
        $this->createIndex('{{%idx-booking_cars_extra_assign-extra_id}}', '{{%booking_cars_extra_assign}}', 'extra_id');

        $this->addForeignKey('{{%fk-booking_cars_extra_assign-car_id}}', '{{%booking_cars_extra_assign}}', 'car_id', '{{%booking_cars}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-booking_cars_extra_assign-extra_id}}', '{{%booking_cars_extra_assign}}', 'extra_id', '{{%booking_cars_extra}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_cars_extra_assign}}');
    }
}
