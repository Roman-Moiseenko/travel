<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_cars}}`.
 */
class m200925_201922_create_booking_cars_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_cars}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'legal_id' => $this->integer(),
            'name' => $this->string(),
            'slug' => $this->string(),
            'created_at' => $this->integer(),
            'status' => $this->integer(),
        ]);
        $this->addForeignKey('{{%fk-booking_cars-legal_id}}', '{{%booking_cars}}', 'legal_id', '{{%admin_user_legals}}', 'id', 'SET NULL', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_cars}}');
    }
}
