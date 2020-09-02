<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_discount}}`.
 */
class m200902_212029_create_booking_discount_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_discount}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer(),
            'who' => $this->integer(),
            'entities' => $this->string(),
            'entities_id' => $this->integer(),
            'promo' => $this->string(),
            'percent' => $this->integer(),
            'count' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_discount}}');
    }
}
