<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_tours}}`.
 */
class m200724_102012_create_booking_tours_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_tours}}', [
            'id' => $this->primaryKey(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_tours}}');
    }
}
