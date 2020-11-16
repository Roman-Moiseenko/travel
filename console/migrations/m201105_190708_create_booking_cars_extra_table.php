<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_cars_extra}}`.
 */
class m201105_190708_create_booking_cars_extra_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_cars_extra}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string(),
            'name_en' => $this->string(),
            'cost' => $this->integer(),
            'sort' => $this->integer(),
            'description' => $this->text(),
            'description_en' => $this->text(),

        ], $tableOptions);
        $this->createIndex('{{%idx-booking_cars_extra-user_id}}', '{{%booking_cars_extra}}', 'user_id');
        $this->addForeignKey('{{%fk-booking_cars_extra-user_id}}', '{{%booking_cars_extra}}', 'user_id', '{{%admin_users}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_cars_extra}}');
    }
}
