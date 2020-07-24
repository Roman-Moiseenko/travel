<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_stays_type}}`.
 */
class m200721_212053_create_booking_stays_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_stays_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'mono' => $this->boolean()
        ], $tableOptions);
        $this->insert('{{%booking_stays_type}}', [
            'name' => 'Аппартаменты',
            'mono' => true
        ]);
        $this->insert('{{%booking_stays_type}}', [
            'name' => 'Загородный дом',
            'mono' => true
        ]);
        $this->insert('{{%booking_stays_type}}', [
            'name' => 'Отель',
            'mono' => false
        ]);
        $this->insert('{{%booking_stays_type}}', [
            'name' => 'Хостел',
            'mono' => false
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_stays_type}}');
    }
}
