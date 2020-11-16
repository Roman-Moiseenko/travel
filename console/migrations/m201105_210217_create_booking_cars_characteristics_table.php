<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_cars_characteristics}}`.
 */
class m201105_210217_create_booking_cars_characteristics_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_cars_characteristics}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'type_variable' => $this->integer()->notNull(),
            'type_car_id' => $this->integer()->notNull(),
            'required' => $this->boolean()->notNull(),
            'default' => $this->string(),
            'variants_json' => 'JSON NOT NULL',
            'sort' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-booking_cars_characteristics-type_car_id}}', '{{%booking_cars_characteristics}}', 'type_car_id');
        $this->addForeignKey('{{%fk-booking_cars_characteristics-type_car_id}}', '{{%booking_cars_characteristics}}', 'type_car_id', '{{%booking_cars_type}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_cars_characteristics}}');
    }
}
