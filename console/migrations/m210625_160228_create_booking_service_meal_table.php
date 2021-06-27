<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_service_meal}}`.
 */
class m210625_160228_create_booking_service_meal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_service_meal}}', [
            'id' => $this->primaryKey(),
            'mark' => $this->string()->notNull(),
            'name' => $this->string(),
            'sort' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_service_meal}}');
    }
}
