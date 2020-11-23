<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%selling_car}}`.
 */
class m201123_135420_create_selling_car_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%selling_car}}', [
            'id' => $this->primaryKey(),
            'calendar_id' => $this->integer()->notNull(),
            'count' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-selling_car-calendar_id}}', '{{%selling_car}}', 'calendar_id');
        $this->addForeignKey('{{%fk-selling_car-calendar_id}}', '{{%selling_car}}', 'calendar_id', '{{%booking_cars_calendar_cost}}', 'id', 'CASCADE', 'RESTRICT');
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%selling_car}}');
    }
}
