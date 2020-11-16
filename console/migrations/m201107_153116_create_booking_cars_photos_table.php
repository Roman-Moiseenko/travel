<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_cars_photos}}`.
 */
class m201107_153116_create_booking_cars_photos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%booking_cars_photos}}', [
            'id' => $this->primaryKey(),
            'car_id' => $this->integer()->notNull(),
            'file' => $this->string()->notNull(),
            'sort' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-booking_cars_photos-car_id}}', '{{%booking_cars_photos}}', 'car_id');
        $this->addForeignKey('{{%fk-booking_cars_photos-car_id}}', '{{%booking_cars_photos}}', 'car_id', '{{%booking_cars}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_cars_photos}}');
    }
}
