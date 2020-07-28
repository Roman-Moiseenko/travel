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
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string(),
            'cost' => $this->integer(),
            'sort' => $this->integer(),
            'description' => $this->string(),

        ], $tableOptions);

        $this->createIndex('{{%idx-booking_tours_extra-user_id}}', '{{%booking_tours_extra}}', 'user_id');
        $this->addForeignKey('{{%fk-booking_tours_extra-user_id}}', '{{%booking_tours_extra}}', 'user_id', '{{%admin_users}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_tours_extra}}');
    }
}
