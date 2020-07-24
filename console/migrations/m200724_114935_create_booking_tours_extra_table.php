<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_tours_extra}}`.
 */
class m200724_114935_create_booking_tours_extra_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_tours_extra}}', [
            'id' => $this->primaryKey(),
            'tours_id' => $this->integer()->notNull(),
            'name' => $this->string(),
            'pay' => $this->boolean(),
            'coast' => $this->integer(),
            'sort' => $this->integer(),
            'description' => $this->string(),

        ], $tableOptions);

        $this->createIndex('{{%idx-booking_tours_extra-tours_id}}', '{{%booking_tours_extra}}', 'tours_id');
        $this->addForeignKey('{{%fk-booking_tours_extra-tours_id}}', '{{%booking_tours_extra}}', 'tours_id', '{{%booking_tours}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_tours_extra}}');
    }
}
